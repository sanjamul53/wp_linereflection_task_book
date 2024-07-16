<?php

/**
 * Plugin Name: Book
 * prefix: BK5
 */

if (!defined('ABSPATH')) {
	exit;
}


define('BK5_ROOTPATH', plugin_dir_path(__FILE__));
define('Bk5_ROOTURL', plugin_dir_url(__FILE__));

// traits
require_once(BK5_ROOTPATH."includes/traits/singleton.php");

// shortcode
require_once(BK5_ROOTPATH."includes/shortcode.php");


// inc
require_once(BK5_ROOTPATH."includes/init.php");


require_once(BK5_ROOTPATH."plugin_loader.php");



