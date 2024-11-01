<?php
if ( !function_exists( 'yag_view_glossary_on_page' ) ) {
	
	function yag_view_glossary_on_page() {

		global $post;

		$display_option = get_post_meta($post->ID, 'yag_definition_display_option', TRUE);
		$excerpt_options = get_post_meta($post->ID, 'yag_definition_display_option_excerpt', TRUE);
			
		wp_nonce_field( 'admin_page_include_glossary.php', 'yag_page_include_nonce' ); 

?>
			<label>Definition Display Options</label>
			<select name="yag_definition_display_option" id="yag_definition_display_option">
				<option value="full">Show It All</option>
				<option value="no-media">No Media</option>
				<option value="excerpt">Only the first...</option>
			</select>
			<div class="yag_metadata_box_excerpt_options" style="display:none;">
				<p>
					Only show the first 
					<input 
						value="<?php echo $excerpt_options['number'] ?>" 
						id="yag_definition_display_option_excerpt_number" 
						type="text" 
						size="4" 
						name="yag_definition_display_option_excerpt[number]"/>
					<div> of 
					<select id="yag_definition_display_option_excerpt_type" name="yag_definition_display_option_excerpt[type]">
						<option value="spaces">Spaces & Characters</option>
						<option value="words">Words</option>
					</select>
					</div>
					</p>
			</div>
		<?php
	}
}