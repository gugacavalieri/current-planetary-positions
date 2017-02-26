<?php
/*
Plugin Name: Current Planetary Positions
Plugin URI: https://isabelcastillo.com/docs/about-current-planetary-positions
Description: Display the current planetary positions in the zodiac signs.
Version: 2.1.1
Author: Isabel Castillo
Author URI: https://isabelcastillo.com
License: GPL2
Text Domain: current-planetary-positions
Domain Path: languages

Copyright 2013 - 2017 Isabel Castillo

This file is part of Current Planetary Positions Plugin.

Current Planetary Positions Plugin is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

Current Planetary Positions Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Current Planetary Positions Plugin; if not, If not, see <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>.
*/
class Current_Planetary_Positions {

	private static $instance = null;
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	private function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'init', array( $this, 'load_textdomain' ) );

		if( ! defined( 'CPP_PLUGIN_DIR' ) )
			define( 'CPP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		require_once CPP_PLUGIN_DIR . 'cpp-widget.php';

    }

	/** 
	 * Load the plugin textdomain
	 * @since 2.1.1
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'current-planetary-positions', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/** 
	 * Register the stylesheet
	 * @since 1.0
	 */
   	public function enqueue() {
		wp_register_style('cpp', plugins_url('/cpp.css', __FILE__));
	}

	/** 
	 * Check that the plugin can work.
	 * @since 1.0
	 */
	public function plugins_loaded() {
		$this->is_sweph_executable();

		// Is this site hosted on Windows?
		if ( strtolower( PHP_SHLIB_SUFFIX ) === 'dll' ) {
			if ( ! defined( 'ZP_WINDOWS_SERVER' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_windows_server' ) );
			}
		}

	}
	/** 
	 * Registers the widget.
	 * @since 1.0
	 */
	public function register_widgets() {
		register_widget( 'cpp_widget' );
	}

	/**
	 * Checks if the Ephemeris has the required file permissions.
	 *
	 * Attemps to set the proper permission.
	 * @since 2.0
	 * @return bool true if permission is (or gets set to) 0755, otherwise false
	 */
	public function is_sweph_executable() {

		$out			= true;
		$file			= CPP_PLUGIN_DIR . 'sweph/swetest';
		$permissions	= substr( sprintf( '%o', fileperms( $file ) ), -4 );

		if ( '0755' !== $permissions ) {

			// If chmod() is enabled
			if ( function_exists( 'chmod' ) &&
			// AND NOT in the array of disabled functions
			! in_array( 'chmod', array_map( 'trim', explode( ', ', ini_get( 'disable_functions' ) ) ) ) &&
			// AND NOT in safe mode
			ini_get( 'safe_mode' ) != 1
			) {

				// Attempt to change permission.
				$change = chmod( $file, 0755 );
				
				if ( ! $change ) {
					$out = false;
					add_action( 'admin_notices', array( $this, 'admin_notice_chmod_failed' ) );
				}
			} else {
				$out = false;
				add_action( 'admin_notices', array( $this, 'admin_notice_chmod_failed' ) );
			}
		}

		return $out;
	}

	/**
	 * Add admin notice when file permissions on ephemeris will not permit the plugin to work.
	 * @since 2.0
	 */
	public function admin_notice_chmod_failed() {

		global $pagenow;

		if ( in_array( $pagenow, array( 'plugins.php', 'widgets.php' ) ) ) {		
			$msg = sprintf( __( 'Your server did not allow Current Planetary Positions to set the necessary file permissions for the Ephemeris. Current Planetary Positions requires this in order to show the correct position of the planets. <a href="%s" target="_blank" rel="nofollow">See this</a> to fix it.', 'current-planetary-positions' ), 'https://isabelcastillo.com/docs/about-current-planetary-positions#docs-swetest' );

			printf( '<div class="notice notice-error is-dismissible"><p>%s</p></div>', $msg );
		}
	}

	/**
	 * Add admin notice when site is hosted on Windows server.
	 * @since 2.0
	 */
	public function admin_notice_windows_server() {

		global $pagenow;

		if ( in_array( $pagenow, array( 'plugins.php', 'widgets.php' ) ) ) {

			$msg = sprintf( __( 'ERROR: Your website server is using a Windows operating system (Windows hosting). For Current Planetary Positions to work on your server, you need the "ZP Windows Server" plugin. See <a href="%s" target="_blank" rel="nofollow">this</a> for details.', 'current-planetary-positions' ), 'https://cosmicplugins.com/downloads/zodiacpress-windows-server/' );

			printf( '<div class="notice notice-error is-dismissible"><p>%s</p></div>', $msg );
		}
	}
}
$current_planetary_postitions = Current_Planetary_Positions::get_instance();
