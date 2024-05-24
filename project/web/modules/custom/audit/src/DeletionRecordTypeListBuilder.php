<?php

declare(strict_types=1);

namespace Drupal\audit;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of deletion record type entities.
 *
 * @see \Drupal\audit\Entity\DeletionRecordType
 */
final class DeletionRecordTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No deletion record types available. <a href=":link">Add deletion record type</a>.',
      [':link' => Url::fromRoute('entity.deletion_record_type.add_form')->toString()],
    );

    return $build;
  }

}
