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
    $textTransformer = \Drupal::service('text_transformer');

    // Using Drupal\user\Entity\User::load or ::loadMultiple
    $another = User::load(2)->getAccountName();

    $build['content'] = [
      '#markup' => $this->t('Hello @username! Say hi to @another', ['@username' => $textTransformer->titleCase($user), '@another' => $another]),
    ];

    // Using entity type manager
    $entityTypeManager = \Drupal::entityTypeManager();
    $storage = $entityTypeManager->getStorage('user');
    $user = $storage->load(2); // Return Drupal\user\Entity\User
    $username = $user->getAccountName();
    ksm($username);

    $username = \Drupal::entityTypeManager()->getStorage('user')->load(2)->getAccountName();
    ksm($username);

    // Load a node.
    $nodeStorage = $entityTypeManager->getStorage('node');
    $node = $nodeStorage->load(1);
    ksm($node);
    
    return $build;
  }

}
