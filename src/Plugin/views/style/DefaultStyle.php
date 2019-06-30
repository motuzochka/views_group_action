<?php

namespace Drupal\views_group_action\Plugin\views\style;

use Drupal\views\Plugin\views\style\DefaultStyle as DefaultStyleDefault;

/**
 * Unformatted style to render rows one after another with no decorations.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "group_action_default",
 *   title = @Translation("Unformatted list (Group Action)"),
 *   help = @Translation("Displays rows one after another."),
 *   theme = "views_view_unformatted_group_action",
 *   display_types = {"normal"}
 * )
 */
class DefaultStyle extends DefaultStyleDefault {

  use ViewsGroupActionStylePluginTrait;

}
