<?php

declare(strict_types=1);

namespace Drupal\audit\Form;

use Drupal\audit\Event\IncidentReport;
use Drupal\audit\Event\IncidentReportEvents;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a audit form.
 */
final class IncidentReportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'audit_incident_report';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['reporter_name'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Reporter name'),
      '#description' => $this->t('Type your name here.'),
    ];

    $form['reporter_email'] = [
      '#type' => 'email',
      '#required' => TRUE,
      '#title' => $this->t('Reporter email'),
      '#description' => $this->t('Type your email here.'),
    ];

    $form['entity'] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => $this->t('Select the entity that was incorrectly deleted'),
      '#options' => $this->getEntities(),
    ];

    $form['report'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Detailed report'),
      '#description' => $this->t('Describe why this was an error.'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  public function getEntities() {
    $storage = \Drupal::entityTypeManager()->getStorage('deletion_record');
    $query = $storage->getQuery();
    $query->sort('deleted', 'DESC');
    $query->accessCheck(TRUE);
    $ids = $query->execute();

    $records = $storage->loadMultiple($ids);
    $entities = [];

    foreach ($records as $key => $item) {
      $entities[$key] = $item->label->value;
    }

    return $entities;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if (mb_strlen($form_state->getValue('message')) < 10) {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('Message should be at least 10 characters.'),
    //     );
    //   }
    // @endcode
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $reporter_name = $form_state->getValue('reporter_name');
    $reporter_email = $form_state->getValue('reporter_email');
    $entity = $form_state->getValue('entity');
    $report = $form_state->getValue('report');
    // Trigger the event.
    $event = new IncidentReport($reporter_name, $reporter_email, $entity, $report);
    \Drupal::service('event_dispatcher')->dispatch($event, IncidentReportEvents::NEW_INCIDENT);

    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
