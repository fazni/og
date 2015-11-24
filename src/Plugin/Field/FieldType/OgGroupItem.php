<?php

/**
 * @file
 * Contains \Drupal\og\OgGroupItem.
 */

namespace Drupal\og\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * OG Group Data class to return TRUE always.
 *
 * @FieldType(
 *   id = "og_group",
 *   label = @Translation("OG Group"),
 *   description = @Translation("OG Group"),
 *   category = @Translation("OG"),
 *   no_ui = TRUE,
 *   default_formatter = "og_ui_group_subscribe",
 * )
 */
class OgGroupItem extends FieldItemBase {

  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [];
  }

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    return [];
  }


  /**
   * {@inheritdoc}
   */
  public function getValue() {
    return TRUE;
  }


}
