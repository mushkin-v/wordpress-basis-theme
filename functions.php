<?php
/**
 * WP Basis Theme functions and definitions
 * 
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, wp_basis_setup(), sets up the theme by registering support
 * for various features in WordPress, such as a custom background and a navigation menu.
 * 
 * When using a child theme
 * @link    http://codex.wordpress.org/Theme_Development
 * @link    http://codex.wordpress.org/Child_Themes
 * you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see 
 * @link     http://codex.wordpress.org/Plugin_API.
 *
 * Php Version 5.3
 *
 * @package    WordPress
 * @subpackage WordPress_Basis_Theme
 * @since      2012-05-08  0.0.1
 * @version    2014-11-03
 * @author     Frank Bültge <frank@bueltge.de>
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

// check for right php version
$correct_php_version = version_compare( phpversion(), '5.3.0', '>=' );

if ( ! $correct_php_version ) {
	echo 'The WP Basis Theme requires <strong>PHP 5.3</strong> or higher.<br>';
	echo 'You are running PHP ' . phpversion();
	exit;
}

if ( ! function_exists( 'wp_basis_load_files' ) ) {
	
	add_action( 'after_setup_theme', 'wp_basis_load_files' );
	
	/**
	 * Automatic load all files from folder inc
	 * Current no subdirectories
	 * 
	 * @since   2013-04-15
	 * @return  void
	 */
	function wp_basis_load_files() {
		
		$inc_directory = 'inc';
		$inc_base = dirname( __FILE__ ) . '/' . $inc_directory . '/';
		$includes = array();
		
		// load required classes
		foreach( glob( $inc_base . '*.php' ) as $path ) {
			
			$key = substr( $path, strpos( $path, $inc_directory ) );
			$key = str_replace( $inc_directory . '/', '', $key );
			// create array with key and path for use in hook
			$includes[ $key ] = $path;
		}
		
		$includes = apply_filters(
			'wp_basis_loader',
			$includes
		);
		
		foreach ( $includes as $key => $path )
			require_once $path;
		
	}
}
