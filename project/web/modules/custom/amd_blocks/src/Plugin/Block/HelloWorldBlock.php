<?php

declare(strict_types=1);

namespace Drupal\amd_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;

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
    // For using current user.
    $user = \Drupal::currentUser()->getAccountName();

    $build['content'] = [
      '#markup' => $this->t('Hello @username! Say hi to @another', ['@username' => $user]),
    ];

    return $build;
  }

}
