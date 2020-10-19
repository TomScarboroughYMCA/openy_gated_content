<?php

namespace Drupal\openy_gated_content;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\recurring_events\Entity\EventInstance;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SegmentContentAccessCheck.
 *
 * @package Drupal\openy_gated_content
 */
class GCUserService implements ContainerInjectionInterface {

  const EDITOR_ROLE = 'virtual_ymca_editor';

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * GCUserService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Get list of Virtual Y roles.
   */
  public function getRoles() {
    $roles = [];
    foreach ($this->entityTypeManager->getStorage('user_role')->loadMultiple() as $role_name => $role) {
      if (strstr($role_name, 'virtual_y') && ($role_name !== self::EDITOR_ROLE)) {
        $roles[$role_name] = $role->label();
      }
    }
    return $roles;
  }

}
