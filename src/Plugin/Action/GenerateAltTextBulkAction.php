<?php

namespace Drupal\auto_alt\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\media\MediaInterface;
use Drupal\media\Entity\Media;

/**
 * @Action(
 *   id = "generate_alt_text_bulk_action",
 *   label = @Translation("Generate Alt Text for Selected Images"),
 *   type = "media"
 * )
 */
class GenerateAltTextBulkAction extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    if ($entity instanceof MediaInterface) {
      \Drupal::logger('auto_alt')->notice('Executing action for entity: @entity', ['@entity' => $entity->id()]);
      $this->generateAltText($entity);
    } else {
      \Drupal::logger('auto_alt')->warning('Invalid entity type for entity: @entity', ['@entity' => $entity ? $entity->id() : 'NULL']);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function executeMultiple(array $entities) {
    if (empty($entities)) {
      \Drupal::messenger()->addError(t('No valid media items selected.'));
      return;
    }

    $processed = 0;
    foreach ($entities as $entity) {
      $this->execute($entity);
      $processed++;
    }
    
    \Drupal::logger('auto_alt')->notice('Processed @count entities', ['@count' => $processed]);
  }

  /**
   * Generates alt text for a media item.
   */
  protected function generateAltText(MediaInterface $entity) {
    if ($entity instanceof Media && $entity->bundle() == 'image') {
      $alt_text = auto_alt_generate_alt_text($entity);
      if ($alt_text) {
        $entity->set('field_media_image', [
          'target_id' => $entity->get('field_media_image')->target_id,
          'alt' => $alt_text,
        ]);
        $entity->save();
        \Drupal::messenger()->addMessage(t('Alt text has been generated and updated for @title.', ['@title' => $entity->label()]));
        \Drupal::logger('auto_alt')->notice('Alt text generated for entity @entity: @alt', ['@entity' => $entity->id(), '@alt' => $alt_text]);
      } else {
        \Drupal::messenger()->addError(t('Failed to generate alt text for @title. Please try again.', ['@title' => $entity->label()]));
        \Drupal::logger('auto_alt')->error('Failed to generate alt text for entity @entity', ['@entity' => $entity->id()]);
      }
    } else {
      \Drupal::logger('auto_alt')->warning('Entity @entity is not an image media', ['@entity' => $entity->id()]);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    return $object instanceof MediaInterface && $object->access('update', $account, $return_as_object);
  }
}