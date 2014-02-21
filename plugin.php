<?php
/*
Plugin Name: Shoestrap Patterns
Plugin URI: http://wpmu.io
Description: Add some patterns for backgrounds.
Version: 0.1
Author: Aristeides Stathopoulos
Author URI:  http://aristeides.com
GitHub Plugin URI:   https://github.com/shoestrap/shoestrap-patterns
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Define the plugin's URL
if ( !defined( 'SSPAT_PLUGIN_URL' ) )
	define( 'SSPAT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Define the plugin's PATH
if ( !defined( 'SSPAT_PLUGIN_PATH' ) )
	define( 'SSPAT_PLUGIN_PATH', dirname( __FILE__ ) );

/**
 * Include the necessary files
 */
function shoestrap_patterns_include_files() {
	require_once( SSPAT_PLUGIN_PATH . '/includes/class.ShoestrapPatterns.php' );
}
add_action( 'shoestrap_include_files', 'shoestrap_patterns_include_files' );