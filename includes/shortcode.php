<?php

namespace BK5\Inc;

class Shortcode {

  public function __construct() {
    add_shortcode('bk5_books', array($this, 'add_shortcode'));
  }

  public function add_shortcode($atts = array(), $content = null, $tag = '') {

    $atts = array_change_key_case((array) $atts, CASE_LOWER);

    extract(shortcode_atts(
      array(
        'id' => '',
        'orderby' => 'date'
      ),
      $atts,
      $tag
    ));

    if (!empty($id)) {
      $id = array_map('absint', explode(',', $id));
    }

    ob_start();

    // must be require. not require_once
    require(BK5_ROOTPATH . 'views/book_shortcode.php');

    // wp_enqueue_script('mv-slider-main-jq');
    // wp_enqueue_style('mv-slider-main-css');
    // wp_enqueue_style('mv-slider-style-css');
    return ob_get_clean();
  }
}
