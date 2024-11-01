<?php
//This functionality has been pulled from the release.

if ( !function_exists( 'yag_view_glossary_word_metadata' ) ) {
	
	function yag_view_glossary_word_metadata() {
	
		global $post;
	
		$display_option = get_post_meta($post->ID, 'yag_definition_display_option', TRUE);
		$excerpt_options = get_post_meta($post->ID, 'yag_definition_display_option_excerpt', TRUE);
			
		wp_nonce_field( 'admin_post_view.php', 'yag_post_word_nonce' ); 
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
		<script type="text/javascript">
		jQuery('document').ready(function(){
			jQuery('#yag_definition_display_option').change(function(){
				
				if( jQuery(this).val() == 'excerpt' )  {
						jQuery('.yag_metadata_box_excerpt_options').show()
					} else {
						jQuery('.yag_metadata_box_excerpt_options').hide()
						jQuery('#yag_definition_display_option_excerpt_number').val('');
					}
				});

			jQuery('#yag_definition_display_option').val('<?php echo $display_option ?>');
			jQuery('#yag_definition_display_option_excerpt_type').val('<?php echo $excerpt_options['type'] ?>');

			if( jQuery('#yag_definition_display_option').val() == 'excerpt' ) {
				jQuery('.yag_metadata_box_excerpt_options').show();
			}
	});
		</script>
		<?php
	}
}