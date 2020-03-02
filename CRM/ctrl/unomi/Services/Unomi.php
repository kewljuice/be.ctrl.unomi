<?php

namespace CRM\ctrl\unomi\Services;

/**
 * Base class for Unomi.
 */
class Unomi {

  /**
   * Unomi settings.
   *
   * @var array
   */
  protected $settings;

  /**
   * Constructor.
   */
  public function __construct() {
    $settings = \CRM_Core_BAO_Setting::getItem('unomi', 'unomi-settings');
    $this->settings = json_decode($settings, TRUE);
  }

}
