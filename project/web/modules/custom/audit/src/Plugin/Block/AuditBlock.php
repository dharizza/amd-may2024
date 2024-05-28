<?php

declare(strict_types=1);

namespace Drupal\audit\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides an audit block block.
 *
 * @Block(
 *   id = "audit_audit_block",
 *   admin_label = @Translation("Audit block"),
 *   category = @Translation("Custom"),
 * )
 */
final class AuditBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $storage = \Drupal::entityTypeManager()->getStorage('deletion_record');
    $query = $storage->getQuery();
    $query->sort('deleted', 'DESC');
    $query->range(0, 3);
    $query->accessCheck(TRUE);
    $ids = $query->execute();

    $records = $storage->loadMultiple($ids);
    $output = '<h3>Recently deleted entities</h3><ul>';

    foreach ($records as $item) {
      $output = $output . '<li>' . $item->label->value . '</li>';
    }
    $output = $output . '</ul>';

    $build['content'] = [
      '#markup' => $output,
    ];
    return $build;
  }

  public function getCacheTags() {
    $tags = [
      'deletion_record_list',
    ];
    return Cache::mergeTags(parent::getCacheTags(), $tags);
  }

}
