<?php

namespace Drupal\views_group_action\Plugin\views\style;

use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\ResultRow;

/**
 * Trait for views group action style plugins.
 */
trait ViewsGroupActionStylePluginTrait {

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    if (!empty($form['grouping'])) {
      /** @var \Drupal\views_group_action\ViewsGroupActionFormPluginManager $manager */
      $plugin_manager = \Drupal::service('plugin.manager.views_group_action_plugin');
      $plugins = [];
      $definitions = $plugin_manager->getDefinitions();
      foreach ($definitions as $id => $def) {
        $instance = $plugin_manager->createInstance($id);
        if ($instance->isApplicable($this->view)) {
          $plugins[$id] = $def['label'];
        }
      }

      foreach ($form['grouping'] as $group_level => $group) {
        $grouping = !empty($this->options['grouping'][$group_level]) ? $this->options['grouping'][$group_level] : [];
        $form['grouping'][$group_level]['group_action'] = [
          '#type' => 'select',
          '#states' => [
            // Hide the settings when grouping field is not chosen.
            'invisible' => [
              ':input[name="style_options[grouping][' . $group_level . '][field]"]' => ['value' => ''],
            ],
          ],
          '#title' => $this->t('Select action for grouped entities'),
          '#default_value' => $grouping['group_action'],
          '#empty_option' => $this->t('- None -'),
          '#options' => $plugins,
        ];
      }
    }
  }

  /**
   * Render the grouping sets.
   *
   * Plugins may override this method if they wish some other way of handling
   * grouping.
   *
   * @param $sets
   *   An array keyed by group content containing the grouping sets to render.
   *   Each set contains the following associative array:
   *   - group: The group content.
   *   - level: The hierarchical level of the grouping.
   *   - rows: The result rows to be rendered in this group..
   *
   * @return array
   *   Render array of grouping sets.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   * @throws \Drupal\Core\Form\EnforcedResponseException
   * @throws \Drupal\Core\Form\FormAjaxException
   */
  public function renderGroupingSets($sets) {
    $output = [];
    $theme_functions = $this->view->buildThemeFunctions('views_group_action_grouping');
    foreach ($sets as $set) {
      $level = isset($set['level']) ? $set['level'] : 0;

      $row = reset($set['rows']);
      // Render as a grouping set.
      if (is_array($row) && isset($row['group'])) {
        $single_output = [
          '#theme' => $theme_functions,
          '#view' => $this->view,
          '#grouping' => $this->options['grouping'][$level],
          '#rows' => $set['rows'],
        ];
      }
      // Render as a record set.
      else {
        if ($this->usesRowPlugin()) {
          foreach ($set['rows'] as $index => $row) {
            $this->view->row_index = $index;
            $set['rows'][$index] = $this->view->rowPlugin->render($row);
          }
        }
        $single_output = $this->renderRowGroup($set['rows']);
      }

      $single_output['#grouping_level'] = $level;
      $single_output['#title'] = $set['group'];
      $single_output['#group_action_form'] = $this->prepareGroupActionForm($set);

      $output[] = $single_output;
    }
    unset($this->view->row_index);
    return $output;
  }

  /**
   * Prepare group action form renderable array.
   *
   * @param array $set
   *   Group set.
   *
   * @return array|null
   *   Form renderable array.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   * @throws \Drupal\Core\Form\EnforcedResponseException
   * @throws \Drupal\Core\Form\FormAjaxException
   */
  protected function prepareGroupActionForm(array $set) {
    $form = NULL;
    $level = $set['level'] ?? NULL;
    if ($level !== NULL) {
      $group_settings = $this->options['grouping'][$level];
      if ($group_settings['group_action']) {

        /** @var \Drupal\views_group_action\ViewsGroupActionFormPluginManager $plugin_manager */
        $plugin_manager = \Drupal::service('plugin.manager.views_group_action_plugin');
        if ($plugin_manager->hasDefinition($group_settings['group_action'])) {
          $available_result_rows = $this->collectAllGroupRows($set);
          $plugin = $plugin_manager->createInstance($group_settings['group_action'], ['view' => $this->view, 'views_result_rows' => $available_result_rows]);
          $form_state = new FormState();
          $form_state->set('action_plugin', $plugin);
          $form = \Drupal::formBuilder()->buildForm('\Drupal\views_group_action\Form\ViewsGroupActionForm', $form_state);
        }
      }
    }
    return $form;
  }

  /**
   * Collect all result rows from sub-sets.
   *
   * @param array $set
   *   Group set.
   *
   * @return \Drupal\views\ResultRow[]
   *   List of views result rows.
   */
  protected function collectAllGroupRows(array $set) {
    $rows = [];
    foreach ($set['rows'] as $pre_row) {
      if ($pre_row instanceof ResultRow) {
        $rows[$pre_row->index] = $pre_row;
      }
      // For the "Unformatted" and "Grid" styles.
      elseif (is_array($pre_row) && isset($pre_row['#row']) && $pre_row['#row'] instanceof ResultRow) {
        $rows[$pre_row['#row']->index] = $pre_row['#row'];
      }
      // We need to go deeper.
      elseif (is_array($pre_row) && !empty($pre_row['rows'])) {
        $rows = $rows + $this->collectAllGroupRows($pre_row);
      }
    }
    return $rows;
  }

}
