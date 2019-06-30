<?php

namespace Drupal\views_group_action_bootstrap\Plugin\views\style;

use Drupal\views_bootstrap\Plugin\views\style\ViewsBootstrapGrid as ViewsBootstrapGridDefault;
use Drupal\views_group_action\Plugin\views\style\ViewsGroupActionStylePluginTrait;

/**
 * Style plugin to render each item in an ordered or unordered list.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_views_bootstrap_grid",
 *   title = @Translation("Bootstrap Grid (Group Action)"),
 *   help = @Translation("Displays rows in a Bootstrap Grid layout"),
 *   theme = "views_bootstrap_grid_group_action",
 *   display_types = {"normal"}
 * )
 */
class ViewsBootstrapGrid extends ViewsBootstrapGridDefault {

  use ViewsGroupActionStylePluginTrait;

}
