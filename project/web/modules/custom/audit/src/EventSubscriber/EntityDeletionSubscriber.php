<?php

declare(strict_types=1);

namespace Drupal\audit\EventSubscriber;

use Drupal\audit\Event\IncidentReport;
use Drupal\audit\Event\IncidentReportEvents;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\core_event_dispatcher\EntityHookEvents;
use Drupal\core_event_dispatcher\Event\Entity\EntityDeleteEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @todo Add description for this subscriber.
 */
final class EntityDeletionSubscriber implements EventSubscriberInterface {

  /**
   * Logger Factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $logger;

  public function __construct(LoggerChannelFactoryInterface $loggerFactory) {
    $this->logger = $loggerFactory->get('audit');
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    $events[EntityHookEvents::ENTITY_DELETE][] = ['logDeletion'];
    $events[IncidentReportEvents::NEW_INCIDENT] = ['logError'];

    return $events;
  }

  /**
   * If entity delete event is triggered, log record.
   */
  public function logDeletion(EntityDeleteEvent $event) {
    $deleted_entity = $event->getEntity();
    $entity_type = $deleted_entity->getEntityTypeId();
    
    // Do nothing for config entities.
    if ($deleted_entity instanceof ConfigEntityInterface) {
      return;
    }

    // Do nothing for path_aliases.
    if ($entity_type === 'path_alias') {
      return;
    }

    // In all other cases, create a DeletionRecord.
    $data = [
      'label' => $deleted_entity->label(),
      'created' => $deleted_entity->created->value,
      'deleted' => time(),
      'deleted_by' => \Drupal::currentUser()->id(),
      'entity_type' => $entity_type,
      'bundle' => $deleted_entity->bundle(),
    ];

    if (isset($deleted_entity->uid)) {
      $data['entity_author'] = $deleted_entity->uid;
    }
    if (isset($deleted_entity->changed)) {
      $data['changed'] = $deleted_entity->changed;
    }

    $record = \Drupal::entityTypeManager()->getStorage('deletion_record')->create($data);
    $record->save();
  }

  /**
   * Reacts to new incidents.
   */
  public function logError(IncidentReport $event) {
    $reporter = $event->getReporterName();
    $email = $event->getReporterEmail();
    $entity = $event->getDeletedEntity();
    $report = $event->getReport();

    // Log the information in watchdog.
    // $logger_factory = \Drupal::service('logger.factory');
    // $logger = $logger_factory->get('audit');
    // $logger->alert('New incident reported by ' . $reporter . ' (' . $email . ') on entity ' . $entity . '. Details: ' . $report . ' !');
    // Using DI:
    $this->logger->alert('New incident reported by ' . $reporter . ' (' . $email . ') on entity ' . $entity . '. Details: ' . $report . ' !');
    
    $event->stopPropagation();
  }

}
