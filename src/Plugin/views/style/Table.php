<?php

namespace Drupal\views_group_action\Plugin\views\style;

use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\views\Plugin\views\style\Table as TableDefault;

/**
 * Style plugin to render each item as a row in a table.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_table",
 *   title = @Translation("Table (Group Action)"),
 *   help = @Translation("Displays rows in a table."),
 *   theme = "views_view_table_group_action",
 *   display_types = {"normal"}
 * )
 */
class Table extends TableDefault implements CacheableDependencyInterface {

  use ViewsGroupActionStylePluginTrait;

}
