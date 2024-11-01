<?php

/**
 * @package yet-another-glossary
 */

require_once( YAG_FOLDER_DIR . '/includes/install.php');
require_once( YAG_FOLDER_DIR . '/includes/views/admin_settings.php');
require_once( YAG_FOLDER_DIR . '/includes/views/admin_post_view.php');
require_once( YAG_FOLDER_DIR . '/includes/views/admin_page_include_glossary.php');


function yagged_in_the_hEEd() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );

	if ( is_admin() ) {
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_style( 'farbtastic' );
	}
}

function yaggerfy_the_admin() {
	add_submenu_page( 'edit.php?post_type=yag_glossary_words', 'Glossary Admin', 'Settings', 'edit_posts', basename(__FILE__), 'yag_view_admin_settings' );
}

/**
 * Notifies people about needing to update the yag settings page
 * if they want to include glossary words on it.
 *
 * @param unknown_type $post_id
 * @param unknown_type $post
 */
function yag_glossary_page_save( $post_id, $post ){
	if( get_post_type( $post ) == 'page' )
    add_action('admin_notices', 'my_admin_notice');
}

/**
 * The message from the yag_glossary_page_save function
 */
function my_admin_notice(){
	echo '<div class="updated"><p>Remember, if you want to display glossary definitions on new pages you need to select it in the Glossary Settings.</p></div>';
}

/**
 * Searches the content of post / pages for words in the glossary
 * If found, wraps the word in the needed html and outputs the definition
 * of the word in a hidden div that will put at the end of the content
 *
 * @param string $content
 * @return string
 * @todo Update this to use the custom posts
 * @todo streamline / update html to work with new qtip code...
 */
function yaggerfy_words( $content )
{
	global $post;
	$yag = new Yag_The_Class();

	if ( $yag->is_yag( $post->post_name ) ) {
		 $content = $yag->yag_content ( $content );
		add_action('wp_footer', 'yag_add_js');
		return $content;
	}
	else {
		return $content;
	}
}


function yag_option_save() {

	if ( ! isset( $_POST['yag_settings_verify'] ) )
		die('Please reload the page and try again' );

	if ( empty($_POST) || ! wp_verify_nonce( $_POST['yag_settings_verify'] , 'yag_settings_verify' ) )
		die( 'Please reload the page and try again' );

	$options = get_option('yag_options');

	if ( isset( $_POST['yag_on_page'] ) )
		$options['yag_on_page'] = $_POST['yag_on_page'];
	else {
		if ( isset( $_POST['yag_on_zero_pages'] ) && $_POST['yag_on_zero_pages'] )
			$options['yag_on_page'] = NULL;
	}

	if ( isset( $_POST['style_background'] ) )
		$options['pretty_pretty_colors']['style_background'] = $_POST['style_background'];

	if ( isset( $_POST['style_color'] ) )
		$options['pretty_pretty_colors']['style_color'] = $_POST['style_color'];

	if ( isset( $_POST['style_border_color'] ) )
		$options['pretty_pretty_colors']['style_border_color'] = $_POST['style_border_color'];

	if ( isset( $_POST['non_english_words'] ) )
		$options['non_english_words'] = 1;
	else
		$options['non_english_words'] = 0;


	if ( update_option( 'yag_options', $options ) )
		die( 'Your Options have been updated.' );
	else
		die( 'oh no, something went wrong.  Are you sure you actually changed something?  I\'d try again.' );

}

function yag_add_js() {
?>
			<script type="text/javascript">
			jQuery(document).ready(function($){
				$('.yag_definition').hide();
				$('.yag_word').hover(
					function(){
						$(this).next('.yag_definition').show();
						var pos = $(this).position();
						$(this) .next('.yag_definition') .css( { 'left': pos.left, 'top': pos.top - 50 }) });
				$('.yag_word').mouseleave(function(){ $('.yag_definition').hide(); });
				});
			</script>
<?php
}


function yag_shortcode(){
	$args = array( 'post_type' => YAG_POST_TYPE_NAME, 'orderby' => 'title', 'order' => 'ASC' );
	$loop = new WP_Query( $args );
	echo '<style> .yag-title{ font-weight: bolder} </style>';
	
	while ( $loop->have_posts() ) : $loop->the_post();
		echo '<div class="yag-title">';
		the_title();
		echo '</div>';
		echo '<div class="entry-content">';
		the_content();
		echo '</div>';
	endwhile;
}

/**
 * Currently not be used, reservered for future use
 */
function yag_glossary_word_metadata_save( $post_id, $post ) {

	return;

	if (
			!isset( $_POST['yag_post_word_nonce'] ) ||
			!wp_verify_nonce( $_POST['yag_post_word_nonce'], 'admin_post_view.php' )
		) {
		return $post_id;
	}

	$display_option = $_POST['yag_definition_display_option'];
	$display_option_excerpt = $_POST['yag_definition_display_option_excerpt'];

	if( !$display_option_excerpt && $display_option == 'excerpt') {
		$display_option_excerpt['number'] = 50;
	}

	update_post_meta( $post_id, 'yag_definition_display_option', $display_option );
	update_post_meta( $post_id, 'yag_definition_display_option_excerpt', $display_option_excerpt );

	return $post_id;
}

function yagger_up_a_metadata_box()
{
	return;

	add_meta_box(
		'yag-glossary-word-metadata',
		'Glossary Word Options',
		'yag_view_glossary_word_metadata',
		YAG_POST_TYPE_NAME,
		$context = 'side',
		$priority = 'default'
		);

	add_meta_box(
		'yag-glossary-display-glossary',
		'Display Glossary On Page',
		'yag_view_glossary_on_page',
		'page',
		$context = 'side',
		$priority = 'default'
		);

}

