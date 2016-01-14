<?php

/**
 * @file
 * Contains \Drupal\block_content\Plugin\Derivative\BlockContent.
 */

namespace Drupal\dfp\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Retrieves block plugin definitions for all custom blocks.
 */
class TagBlock extends DeriverBase implements ContainerDeriverInterface {
  use StringTranslationTrait;

  /**
   * The DFP tag storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $tagStorage;

  /**
   * Constructs a TagBlock object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $tag_storage
   *   The DFP tag storage.
   */
  public function __construct(EntityStorageInterface $tag_storage) {
    $this->tagStorage = $tag_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    $entity_type_manager = $container->get('entity_type.manager');
    return new static(
      $entity_type_manager->getStorage('dfp_tag')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $tags = $this->tagStorage->loadMultiple();
    /** @var $tag \Drupal\dfp\Entity\TagInterface */
    foreach ($tags as $tag) {
      if ($tag->hasBlock()) {
        $this->derivatives[$tag->uuid()] = $base_plugin_definition;
        $this->derivatives[$tag->uuid()]['admin_label'] = $this->t('DFP tag: @slotname', array('@slotname' => $tag->slot()));
        $this->derivatives[$tag->uuid()]['config_dependencies']['config'] = array(
          $tag->getConfigDependencyName()
        );
      }
    }
    return parent::getDerivativeDefinitions($base_plugin_definition);
  }
}