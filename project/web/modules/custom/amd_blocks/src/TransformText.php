<?php

namespace Drupal\amd_blocks;

/**
 * Class for TransformText services.
 */
class TransformText {
  /**
   * @param $text string
   * 
   * Return $text reversed.
   */
  public function reverse($text) {
    return strrev($text);
  }

  /**
   * @param $text string
   * 
   * Return $text with all letter uppercase.
   */
  public function uppercase($text) {
    return strtoupper($text);
  }

  /**
   * @param $text string
   * 
   * Return $text using title case format.
   */
  public function titleCase($text) {
    return ucfirst($text);
  }
}