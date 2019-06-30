<?php

namespace Drupal\views_group_action_bootstrap\Plugin\views\style;

use Drupal\views_bootstrap\Plugin\views\style\ViewsBootstrapListGroup as ViewsBootstrapListGroupDefault;
use Drupal\views_group_action\Plugin\views\style\ViewsGroupActionStylePluginTrait;

/**
 * Style plugin to render each item in an ordered or unordered list.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_views_bootstrap_list_group",
 *   title = @Translation("Bootstrap List Group (Group Action)"),
 *   help = @Translation("Displays rows in a Bootstrap List Group."),
 *   theme = "views_bootstrap_list_group_group_action",
 *   display_types = {"normal"}
 * )
 */
class ViewsBootstrapListGroup extends ViewsBootstrapListGroupDefault {

  use ViewsGroupActionStylePluginTrait;

}
