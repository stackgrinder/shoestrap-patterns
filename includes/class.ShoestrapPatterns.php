<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'ShoestrapPatterns' ) ) {

	/**
	* The "Patterns" module.
	* This used to be part of Shoestrap core before version 3.1.1,
	* at which point we decided to remove it and build it as a separate plugin.
	*/
	class ShoestrapPatterns {

		function __construct() {
			add_filter( 'redux/options/' . SHOESTRAP_OPT_NAME . '/sections', array( $this, 'options' ), 48 );
			add_action( 'wp_enqueue_scripts', array( $this, 'body_css' ), 101 );
			add_action( 'wp_enqueue_scripts', array( $this, 'jumbo_css' ), 101 );
		}

		/**
		 * The admin options
		 */
		function options() {
			global $redux;

			//Background Patterns Reader
			$bg_pattern_images_path = SSPAT_PLUGIN_PATH . '/assets/patterns';
			$bg_pattern_images_url  = SSPAT_PLUGIN_URL . 'assets/patterns/';

			$bg_pattern_images      = array();

			if ( is_dir( $bg_pattern_images_path ) ) {
				if ( $bg_pattern_images_dir = opendir( $bg_pattern_images_path ) ) {
					$bg_pattern_images = array();

					while ( ( $bg_pattern_images_file = readdir( $bg_pattern_images_dir ) ) !== false ) {
						if( stristr( $bg_pattern_images_file, '.png' ) !== false || stristr( $bg_pattern_images_file, '.jpg' ) !== false )
							array_push( $bg_pattern_images, $bg_pattern_images_url . $bg_pattern_images_file );
					}
				}
			}

			// Patterns section
			$section = array(
				'title' => __( 'Patterns', 'shoestrap' ),
				'icon'  => 'el-icon-photo icon-large',
			);

			/**
			 * Body Background
			 */

			$fields[] = array(
				'title'     => __( 'Use a Background Pattern for the body.', 'shoestrap' ),
				'desc'      => __( 'Select one of the already existing Background Patterns. Default: OFF.', 'shoestrap' ),
				'id'        => 'background_pattern_toggle',
				'default'   => 0,
				'type'      => 'switch'
			);

			$fields[] = array(
				'title'     => __( 'Body Background Pattern', 'shoestrap' ),
				'desc'      => __( 'Select a background pattern.', 'shoestrap' ),
				'id'        => 'background_pattern',
				'required'  => array( 'background_pattern_toggle','=',array( '1' ) ),
				'default'   => '',
				'tiles'     => true,
				'type'      => 'image_select',
				'options'   => $bg_pattern_images,
			);

			/**
			 * Jumbotron Background
			 */

			$fields[] = array(
				'title'     => __( 'Use a Background Pattern for the Jumbotron', 'shoestrap' ),
				'desc'      => __( 'Select one of the already existing Background Patterns. Default: OFF.', 'shoestrap' ),
				'id'        => 'jumbotron_background_pattern_toggle',
				'default'   => 0,
				'type'      => 'switch'
			);

			$fields[] = array(
				'title'     => __( 'Choose a Background Pattern', 'shoestrap' ),
				'desc'      => __( 'Select a background pattern.', 'shoestrap' ),
				'id'        => 'jumbotron_background_pattern',
				'required'  => array( 'jumbotron_background_pattern_toggle','=',array( '1' ) ),
				'default'   => '',
				'tiles'     => true,
				'type'      => 'image_select',
				'options'   => $bg_pattern_images,
			);

			$section['fields'] = $fields;
			$section = apply_filters( 'shoestrap_module_blog_modifier', $section );
			$sections[] = $section;

			return $sections;
		}

		/**
		 * Adds the necessary CSS for body backgrounds
		 */
		function body_css() {

			$pattern_toggle   = shoestrap_getVariable( 'background_pattern_toggle' );
			$bg_pattern       = shoestrap_getVariable( 'background_pattern' );

			// Do not process if there is no need to.
			if ( $pattern_toggle == 0 )
				return;

			$background = ( $pattern_toggle && !empty( $bg_pattern ) ) ? set_url_scheme( $bg_pattern ) : '';

			$style = '';

			if ( ( $pattern_toggle == 1 ) && !empty( $background ) ) {
				// Add the background image
				$style .= 'body { background-image: url( "' . $background . '" ); }';
			}
			wp_add_inline_style( 'shoestrap_css', $style );
		}

		/**
		 * Adds the necessary CSS for Jumbotron backgrounds
		 */
		function jumbo_css() {

			$pattern_toggle   = shoestrap_getVariable( 'jumbotron_background_pattern_toggle' );
			$bg_pattern       = shoestrap_getVariable( 'jumbotron_background_pattern' );

			// Do not process if there is no need to.
			if ( $pattern_toggle == 0 )
				return;

			$background = ( $pattern_toggle && !empty( $bg_pattern ) ) ? set_url_scheme( $bg_pattern ) : '';

			$style = '';

			if ( ( $pattern_toggle == 1 ) && !empty( $background ) ) {
				// Add the background image
				$style .= 'div.jumbotron { background-image: url( "' . $background . '" ); }';
			}
			wp_add_inline_style( 'shoestrap_css', $style );
		}
	}
	$patterns = new ShoestrapPatterns();
}