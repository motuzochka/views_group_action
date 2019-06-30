<?php

namespace Drupal\views_group_action_footable\Plugin\views\style;

use Drupal\footable\Plugin\views\style\FooTable as FooTableDefault;
use Drupal\views_group_action\Plugin\views\style\ViewsGroupActionStylePluginTrait;

/**
 * Style plugin to render a table as a FooTable.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_footable",
 *   title = @Translation("FooTable (Group Action)"),
 *   help = @Translation("Render a table as a FooTable."),
 *   theme = "views_view_footable_group_action",
 *   display_types = { "normal" }
 * )
 */
class FooTable extends FooTableDefault {

  use ViewsGroupActionStylePluginTrait;

}
