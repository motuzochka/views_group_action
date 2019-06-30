<?php

namespace Drupal\views_group_action\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Class ViewsGroupActionForm.
 */
class ViewsGroupActionForm extends FormBase {

  /**
   * Keep track of how many times the form is placed on a page.
   *
   * @var int
   */
  protected static $instanceId;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new ViewsGroupActionForm object.
   *
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   */
  public function __construct(
    TimeInterface $time,
    AccountProxyInterface $current_user
  ) {
    $this->time = $time;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('datetime.time'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   *
   * @link https://drupal.stackexchange.com/a/272176/78534
   */
  public function getFormId() {
    if (empty(self::$instanceId)) {
      self::$instanceId = 1;
    }
    else {
      self::$instanceId++;
    }
    return 'views_group_action_form _' . self::$instanceId;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    return $this->getActionPlugin($form_state)
      ->buildActionForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $this->getActionPlugin($form_state)
      ->validateActionForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->getActionPlugin($form_state)
      ->submitActionForm($form, $form_state);
  }

  /**
   * Get the Views group action form plugin from the FormState object.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return \Drupal\views_group_action\Plugin\ViewGroupAction\Form\ActionFormInterface
   *   The Views group action form plugin.
   */
  protected function getActionPlugin(FormStateInterface $form_state) {
    return $form_state->get('action_plugin');
  }

}
