<?php

namespace Drupal\views_group_action_bootstrap\Plugin\views\style;

use Drupal\views_bootstrap\Plugin\views\style\ViewsBootstrapTable as ViewsBootstrapTableDefault;
use Drupal\views_group_action\Plugin\views\style\ViewsGroupActionStylePluginTrait;

/**
 * Style plugin to render each item as a row in a table.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_bootstrap_table",
 *   title = @Translation("Bootstrap Table (Group Action)"),
 *   help = @Translation("Displays rows in a table."),
 *   theme = "views_bootstrap_table_group_action",
 *   display_types = {"normal"}
 * )
 */
class ViewsBootstrapTable extends ViewsBootstrapTableDefault {

  use ViewsGroupActionStylePluginTrait;

}
