<?php

namespace Drupal\views_group_action\Plugin\views\style;

use Drupal\views\Plugin\views\style\HtmlList as HtmlListDefault;

/**
 * Style plugin to render each item in an ordered or unordered list.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_html_list",
 *   title = @Translation("HTML List (Group Action)"),
 *   help = @Translation("Displays rows as HTML list."),
 *   theme = "views_view_list_group_action",
 *   display_types = {"normal"}
 * )
 */
class HtmlList extends HtmlListDefault {

  use ViewsGroupActionStylePluginTrait;

}
