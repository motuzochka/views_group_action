<?php

namespace Drupal\views_group_action\Plugin\views\style;

use Drupal\views\Plugin\views\style\Grid as GridDefault;

/**
 * Style plugin to render each item in a grid cell.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_grid",
 *   title = @Translation("Grid (Group Action)"),
 *   help = @Translation("Displays rows in a grid."),
 *   theme = "views_view_grid_group_action",
 *   display_types = {"normal"}
 * )
 */
class Grid extends GridDefault {

  use ViewsGroupActionStylePluginTrait;

}
