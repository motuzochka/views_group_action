<?php

namespace Drupal\views_group_action\Plugin\ViewGroupAction;

use Drupal\views\ViewExecutable;

/**
 * Defines an interface for View Group Action plugins.
 */
interface ViewsGroupActionPluginInterface {

  /**
   * Determines if the plugin is compatible in this context.
   *
   * @param \Drupal\views\ViewExecutable $view
   *   The view which has the display with current style attached.
   *
   * @return bool
   *   True if applicable or false if not applicable.
   */
  public function isApplicable(ViewExecutable $view);

}
