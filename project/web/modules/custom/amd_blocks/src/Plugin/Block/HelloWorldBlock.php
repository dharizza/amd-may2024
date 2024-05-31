<?php

declare(strict_types=1);

namespace Drupal\amd_blocks\Plugin\Block;

use Drupal\amd_blocks\TransformText;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an amdblockshelloworld block.
 *
 * @Block(
 *   id = "amd_blocks_hello_world",
 *   admin_label = @Translation("AmdBlocksHelloWorld"),
 *   category = @Translation("Custom"),
 * )
 */
final class HelloWorldBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Instance of currentUser service.
   * 
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * Instance of text_transformer service.
   * 
   * @var \Drupal\amd_blocks\TransformText
   */
  protected $textTransformer;

  /**
   * Instance of entityTypeManager service.
   * 
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('text_transformer'),
      $container->get('entity_type.manager')
    );
  }

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxy $currentUser, TransformText $textTransformer, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $currentUser;
    $this->textTransformer = $textTransformer;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    // For using current user.
    // $user = \Drupal::currentUser()->getAccountName();
    // For using current user with DI.
    $user = $this->currentUser->getAccountName();

    // Not needed anymore because we already injected it.
    // $textTransformer = \Drupal::service('text_transformer');

    // Using Drupal\user\Entity\User::load or ::loadMultiple
    $another = User::load(2)->getAccountName();

    $build['content'] = [
      '#markup' => $this->t('Hello @username! Say hi to @another', ['@username' => $this->textTransformer->titleCase($user), '@another' => $another]),
    ];

    // Using entity type manager
    // Next line is no longer needed because we injected the dependency.
    // $entityTypeManager = \Drupal::entityTypeManager();
    $storage = $this->entityTypeManager->getStorage('user');
    $user = $storage->load(2); // Return Drupal\user\Entity\User
    $username = $user->getAccountName();
    ksm($username);

    $username = $this->entityTypeManager->getStorage('user')->load(2)->getAccountName();
    ksm($username);

    // Load a node.
    $nodeStorage = $this->entityTypeManager->getStorage('node');
    $node = $nodeStorage->load(1);
    ksm($node);
    
    return $build;
  }

}
