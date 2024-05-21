<?php

declare(strict_types=1);

namespace Drupal\amd_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an amdblockshelloworld block.
 *
 * @Block(
 *   id = "amd_blocks_hello_world",
 *   admin_label = @Translation("AmdBlocksHelloWorld"),
 *   category = @Translation("Custom"),
 * )
 */
final class HelloWorldBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#markup' => $this->t('Hello!'),
    ];
    return $build;
  }

}
