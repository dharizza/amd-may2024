<?php

declare(strict_types=1);

namespace Drupal\audit\Entity;

use Drupal\audit\DeletionRecordInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the deletion record entity class.
 *
 * @ContentEntityType(
 *   id = "deletion_record",
 *   label = @Translation("Deletion Record"),
 *   label_collection = @Translation("Deletion Records"),
 *   label_singular = @Translation("deletion record"),
 *   label_plural = @Translation("deletion records"),
 *   label_count = @PluralTranslation(
 *     singular = "@count deletion records",
 *     plural = "@count deletion records",
 *   ),
 *   bundle_label = @Translation("Deletion Record type"),
 *   handlers = {
 *     "list_builder" = "Drupal\audit\DeletionRecordListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\audit\Form\DeletionRecordForm",
 *       "edit" = "Drupal\audit\Form\DeletionRecordForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "deletion_record",
 *   admin_permission = "administer deletion_record types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/deletion-record",
 *     "add-form" = "/deletion-record/add/{deletion_record_type}",
 *     "add-page" = "/deletion-record/add",
 *     "canonical" = "/deletion-record/{deletion_record}",
 *     "edit-form" = "/deletion-record/{deletion_record}/edit",
 *     "delete-form" = "/deletion-record/{deletion_record}/delete",
 *     "delete-multiple-form" = "/admin/content/deletion-record/delete-multiple",
 *   },
 *   bundle_entity_type = "deletion_record_type",
 *   field_ui_base_route = "entity.deletion_record_type.edit_form",
 * )
 */
final class DeletionRecord extends ContentEntityBase implements DeletionRecordInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the deletion record was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the deletion record was last edited.'));

    return $fields;
  }

}
