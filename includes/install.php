<?php

function yag_create_post_type() {

$labels = array(
    'name' 								=> _x('Glossary Words', 'post type general name'),
    'singular_name' 			=> _x('Glossary Word', 'post type singular name'),
    'add_new' 						=> _x('Add New', 'book'),
    'add_new_item' 				=> __('Add New Word'),
    'edit_item' 					=> __('Edit Word'),
    'new_item' 						=> __('New Word'),
    'all_items' 					=> __('All Words'),
    'view_item' 					=> __('View Word'),
    'search_items' 				=> __('Search Words'),
    'not_found' 					=> __('No words found'),
    'not_found_in_trash' 	=> __('No word found in Trash'),
    'parent_item_colon' 	=> '',
    'menu_name' 					=> __('Glossary Words'),
  );

  $args = array(
    'labels' 							=> $labels,
    'public' 							=> true,
    'publicly_queryable' 	=> true,
    'show_ui' 						=> true,
    'show_in_menu' 				=> true,
    'query_var' 					=> true,
    'rewrite' 						=> array( 'slug' => _x( 'glossary', 'URL slug' ) ),
    'capability_type' 		=> 'post',
    'has_archive' 				=> true,
    'hierarchical' 				=> false,
    'menu_position' 			=> null,
    'supports' 						=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
  );

  register_post_type( YAG_POST_TYPE_NAME, $args );

	yag_upgrade_to_two();
}

/**
  * Updates words that were saved in the old way to the new way
  *
  * @return boolean
	*/
function yag_upgrade_to_two() {

	$yags = get_option('yags', FALSE);

	if ( $yags ) {

		foreach ( $yags as $yag ) {

			$post['post_type']		= YAG_POST_TYPE_NAME;
			$post['post_title']		= $yag['keyword'];
			$post['post_name'] 		= strtolower($yag['keyword']);
			$post['post_content']	= $yag['content'];
			$post['post_status']	= 'draft';

			wp_insert_post( $post );
		}

		update_option( 'yags-backup', $yags );
		delete_option( 'yags' );
	}
	
	return TRUE;
}
