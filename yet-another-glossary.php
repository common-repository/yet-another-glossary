<?php

/**
 * @package yet-another-glossary
 */
/*
Plugin Name: Yet Another Glossary
Plugin URI:  http://thefifthone.com/wordpress-plugins/yet-another-glossary
Description: Simple Definition / Glossary Plugin.
Version: 2.0.2
Author:  Will Haley, ABT
Author URI: http://atlanticbt.com
*/
/*
 This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! defined( 'YAG_FOLDER_DIR' ) )
	define( 'YAG_FOLDER_DIR', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'YAG_POST_TYPE_NAME' ) )
	define('YAG_POST_TYPE_NAME', 'yag_glossary_words');

require_once( YAG_FOLDER_DIR . "/includes/init.php");
require_once( YAG_FOLDER_DIR . "/includes/classes/The_Yag.php");

add_action( 'init', 'yag_create_post_type' );
add_action( 'init', 'yagged_in_the_hEEd');

add_action( 'admin_menu', 'yaggerfy_the_admin');

add_action( 'save_post', 'yag_glossary_word_metadata_save', 10, 2 );
add_action( 'save_post', 'yag_glossary_page_save', 10, 3 );

add_action( 'wp_ajax_yag_option_save', 'yag_option_save' );

add_filter( 'the_content','yaggerfy_words');

add_shortcode( 'YAGlossaryPage', 'yag_shortcode' );
/**
 * This will be used on future releases.  For now it is being pulled for th 2.0.0 release. 
 */
//add_action( 'add_meta_boxes', 'yagger_up_a_metadata_box' );

?>