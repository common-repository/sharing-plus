<?php
/*
 * File for sidebar and widgets
 * @package ThemeCentury
 * @subpackage Sharing Plus
 * @since 1.0.0
 */
require_once dirname( __FILE__ ) . '/fields/tcy-widget-fields.php';
require_once dirname( __FILE__ ) . '/fields/tcy-master-widget.php';
require_once dirname( __FILE__ ) . '/tcy-follower-widget.php';

if(!function_exists('sharing_plus_widget_initialize')):

	/**
	 * Sharing Plus Widget Initialize.
	 *
	 * @package ThemeCentury
	 * @subpackage Sharing Plus
	 * @since 1.0.0
	 * @param null
 	 * @return null
	 */
	function sharing_plus_widget_initialize(){

		register_widget( 'Sharing_Plus_Follower_Widget' );

		/**
		 * sharing_plus_register_widget hook
		 * @since 1.0.0
		 */
		do_action('sharing_plus_register_widget');

	}

endif;

add_action('widgets_init', 'sharing_plus_widget_initialize');
