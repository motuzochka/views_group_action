<?php

namespace Drupal\views_group_action\Plugin\ViewGroupAction\Form;

use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ResaveEntityActionForm.
 *
 * @ViewGroupActionForm(
 *   id = "resave_entity",
 *   label = @Translation("Resave Entity"),
 * )
 */
class ResaveEntityActionForm extends ActionFormBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager,
    MessengerInterface $messenger
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildActionForm(array $form, FormStateInterface $form_state) {
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Resave Entities'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateActionForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitActionForm(array &$form, FormStateInterface $form_state) {
    $processed_entities = $this->getResultEntities();

    foreach ($processed_entities as $processed_entity) {
      try {
        $processed_entity->save();
        $this->messenger->addStatus($this->t('Entity "@label" (ID: @id) has been re-saved.', [
          '@label' => $processed_entity->label(),
          '@id' => $processed_entity->id(),
        ]));
      }
      catch (EntityStorageException $e) {
        $this->messenger->addError($this->t("Entity \"@label\" (ID: @id) wasn't saved", [
          '@label' => $processed_entity->label(),
          '@id' => $processed_entity->id(),
        ]));
      }
    }
  }

}
