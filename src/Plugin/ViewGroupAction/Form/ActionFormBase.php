<?php

namespace Drupal\views_group_action\Plugin\ViewGroupAction\Form;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\views\ViewExecutable;

/**
 * Provides the base class for View group action form plugin.
 */
abstract class ActionFormBase extends PluginBase implements ActionFormInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->setConfiguration($configuration);
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'view' => NULL,
      'views_result_rows' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    $this->configuration = NestedArray::mergeDeep($this->defaultConfiguration(), $configuration);
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    if (!$form_state->getErrors()) {
      $this->configuration = [];
      foreach ($form_state->getValue($form['#parents']) as $key => $value) {
        $this->configuration[$key] = $value;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginLabel() {
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * Get all entities from views result rows.
   *
   * @return \Drupal\Core\Entity\EntityInterface[]
   *   Processing entities.
   */
  protected function getResultEntities() {
    $entities = [];
    if (!empty($this->configuration['views_result_rows'])) {
      foreach ($this->configuration['views_result_rows'] as $result_row) {
        if (!empty($result_row->_entity) && $result_row->_entity instanceof EntityInterface) {
          $entities[$result_row->_entity->id()] = $result_row->_entity;
        }
      }
    }
    return $entities;
  }

  /**
   * {@inheritdoc}
   */
  public function isApplicable(ViewExecutable $view) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  abstract public function buildActionForm(array $form, FormStateInterface $form_state);

  /**
   * {@inheritdoc}
   */
  abstract public function validateActionForm(array &$form, FormStateInterface $form_state);

  /**
   * {@inheritdoc}
   */
  abstract public function submitActionForm(array &$form, FormStateInterface $form_state);

}
