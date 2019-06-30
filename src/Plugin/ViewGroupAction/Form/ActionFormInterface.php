<?php

namespace Drupal\views_group_action\Plugin\ViewGroupAction\Form;

use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\views_group_action\Plugin\ViewGroupAction\ViewsGroupActionPluginInterface;

/**
 * Defines the interface for View group action form plugin.
 */
interface ActionFormInterface extends ViewsGroupActionPluginInterface, ConfigurablePluginInterface, PluginFormInterface, PluginInspectionInterface, DerivativeInspectionInterface {

  /**
   * Gets the Views group action plugin label.
   *
   * @return string
   *   The Views group action plugin label.
   */
  public function getPluginLabel();

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildActionForm(array $form, FormStateInterface $form_state);

  /**
   * Form validation handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateActionForm(array &$form, FormStateInterface $form_state);

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitActionForm(array &$form, FormStateInterface $form_state);

}
