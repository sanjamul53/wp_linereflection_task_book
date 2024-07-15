<?php

namespace BK5\Inc\Traits;

Trait Singleton {

    private static $instance = null;

    public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


}