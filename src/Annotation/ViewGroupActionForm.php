<?php

namespace Drupal\views_group_action\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines the Views group action from plugin annotation object.
 *
 * Plugin namespace: Plugin\ViewGroupAction\Form.
 *
 * @Annotation
 */
class ViewGroupActionForm extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
