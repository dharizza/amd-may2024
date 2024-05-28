<?php

namespace Drupal\audit\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Wraps a incident report event for event subscribers.
 */
class IncidentReport extends Event {
  /**
   * Reporter name.
   *
   * @var string
   */
  protected $reporterName;

  /**
   * Reporter email.
   *
   * @var string
   */
  protected $reporterEmail;

  /**
   * Deleted entity.
   *
   * @var int
   */
  protected $entity;

  /**
   * Detailed report.
   *
   * @var string
   */
  protected $report;

  /**
   * Constructs an incident report event object.
   *
   * @param string $reporterName
   *   Reporter name.
   * @param string $reporterEmail
   *   Reporter email.
   * @param int $entity
   *   Entity deleted.
   * @param string $report
   *   Dtailed description of the issue.
   */
  public function __construct($reporterName, $reporterEmail, $entity, $report) {
    $this->reporterName = $reporterName;
    $this->reporterEmail = $reporterEmail;
    $this->entity = $entity;
    $this->report = $report;
  }

  /**
   * Get the reporter name.
   *
   * @return string
   *   The reporter name.
   */
  public function getReporterName() {
    return $this->reporterName;
  }

  /**
   * Get the reporter email.
   *
   * @return string
   *   The reporter email.
   */
  public function getReporterEmail() {
    return $this->reporterEmail;
  }

  /**
   * Get the deleted entity.
   *
   * @return string
   *   Deleted entity,
   */
  public function getDeletedEntity() {
    return $this->entity;
  }

  /**
   * Get the detailed report.
   *
   * @return string
   *   Detailed report.
   */
  public function getReport() {
    return $this->report;
  }

}