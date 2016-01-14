<?php

/**
 * @file
 * Contains \Drupal\dfp\Entity\Tag.
 */

namespace Drupal\dfp\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Brightcove API client configuration entity class.
 *
 * @todo list_cache_tags
 *
 * @ConfigEntityType(
 *   id = "dfp_tag",
 *   config_prefix = "tag",
 *   label = @Translation("DFP tag"),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\dfp\Form\Tag",
 *       "edit" = "Drupal\dfp\Form\Tag",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     },
 *     "list_builder" = "Drupal\dfp\View\TagList",
 *     "view_builder" = "Drupal\dfp\View\TagViewBuilder",
 *   },
 *   links = {
 *     "edit-form" = "/admin/structure/dfp_ads/tags/manage/{tag}",
 *     "delete-form" = "/admin/structure/dfp_ads/tags/manage/{tag}/delete",
 *     "collection" = "/admin/structure/dfp_ads/tags",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "slot"
 *   },
 *   admin_permission = "Administer DFP",
 *   list_cache_tags = { "rendered" },
 *   config_export = {
 *     "id",
 *     "slot",
 *     "size",
 *     "adunit",
 *     "slug",
 *     "block",
 *     "short_tag",
 *     "breakpoints",
 *     "targeting",
 *     "adsense_backfill"
 *   },
 * )
 */
class Tag extends ConfigEntityBase implements TagInterface {

  /**
   * The unique tag ID.
   *
   * Limited to d7 machine name regex.
   *
   * @var string
   */
  protected $id;

  /**
   * The ad slot name.
   *
   * @var string
   */
  protected $slot;

  /**
   * Out of page (interstitial) ad slot.
   *
   * Use Context module to place the Ad slot on the page.
   *
   * @var boolean
   *
   * @todo work out why this exists.
   */
  //protected $out_of_page;

  /**
   * Size(s).
   *
   * Example: 300x600,300x250. For Out Of Page slots, use 0x0
   *
   * @var string
   */
  protected $size;

  /**
   * The default Brightcove player to use with this client.
   *
   * Ad Unit Patterns can only include letters, numbers, hyphens, dashes,
   * periods, slashes and tokens.
   *
   * @var string
   */
  protected $adunit;

  /**
   * Slug.
   *
   * Override the default slug for this ad tag. Use <none> for no slug. Leave
   * this field empty to use the default slug. Example: Advertisement
   *
   * @var string
   */
  protected $slug;

  /**
   * Create a block for this ad tag.
   *
   * @var boolean
   */
  protected $block = TRUE;

  /**
   * Render this tag without javascript.
   *
   * Use this option for ads included in emails.
   *
   * @var boolean
   */
  protected $short_tag = FALSE;

  /**
   * @var array
   */
  protected $breakpoints = [];

  /**
   * @var array
   */
  protected $targeting = [];

  /**
   * @var array
   */
  protected $adsense_backfill = [];

  /**
   * {@inheritdoc}
   */
  public function slot() {
    return $this->label();
  }

  /**
   * {@inheritdoc}
   */
  public function size() {
    return $this->size;
  }

  /**
   * {@inheritdoc}
   */
  public function adunit() {
    return $this->adunit;
  }

  /**
   * {@inheritdoc}
   */
  public function slug() {
    return $this->slug;
  }

  /**
   * {@inheritdoc}
   */
  public function hasBlock() {
    return $this->block;
  }

  /**
   * {@inheritdoc}
   */
  public function shortTag() {
    return $this->short_tag;
  }

  public function targeting() {
    return $this->targeting;
  }

  public function breakpoints() {
    return $this->breakpoints;
  }

  public function adsenseAdTypes() {
    return isset($this->adsense_backfill['ad_types']) ? $this->adsense_backfill['ad_types'] : NULL;
  }

  public function adsenseChannelIds() {
    return isset($this->adsense_backfill['channel_ids']) ? $this->adsense_backfill['channel_ids'] : NULL;
  }

  public function adsenseColor($setting) {
    return isset($this->adsense_backfill['color'][$setting]) ? $this->adsense_backfill['color'][$setting] : NULL;
  }

  public function adsenseColors() {
    return isset($this->adsense_backfill['color']) ? $this->adsense_backfill['color'] : [];
  }

}