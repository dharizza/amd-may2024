<?php

declare(strict_types=1);

namespace Drupal\audit\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Deletion Record type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "deletion_record_type",
 *   label = @Translation("Deletion Record type"),
 *   label_collection = @Translation("Deletion Record types"),
 *   label_singular = @Translation("deletion record type"),
 *   label_plural = @Translation("deletion records types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count deletion records type",
 *     plural = "@count deletion records types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\audit\Form\DeletionRecordTypeForm",
 *       "edit" = "Drupal\audit\Form\DeletionRecordTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\audit\DeletionRecordTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer deletion_record types",
 *   bundle_of = "deletion_record",
 *   config_prefix = "deletion_record_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/deletion_record_types/add",
 *     "edit-form" = "/admin/structure/deletion_record_types/manage/{deletion_record_type}",
 *     "delete-form" = "/admin/structure/deletion_record_types/manage/{deletion_record_type}/delete",
 *     "collection" = "/admin/structure/deletion_record_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   },
 * )
 */
final class DeletionRecordType extends ConfigEntityBundleBase {

  /**
   * The machine name of this deletion record type.
   */
  protected string $id;

  /**
   * The human-readable name of the deletion record type.
   */
  protected string $label;

}
