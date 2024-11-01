<?php
if ( !function_exists( 'yag_view_admin_settings' ) ) {

	function yag_view_admin_settings() {
		$yag_settings = get_option('yag_options');
		$pages = get_pages();
		$count = count( $pages );
?>
<style>
	ul.yag { list-style-type: none; margin: auto; height: 20px; }
	.yag li { float: left; padding-left: 5px; padding-right: 5px; width:20%}
	#yag_example_container {
		color: <?php echo $yag_settings['pretty_pretty_colors']['style_color']?>;
		background-color: <?php echo $yag_settings['pretty_pretty_colors']['style_background']?>;
		border: 1px solid <?php echo $yag_settings['pretty_pretty_colors']['style_border_color']?>;
		padding:5px;
		width: 250px;
	}
	.yag_message { height: 10px; margin: auto; text-align: left; padding: 5px; }
	.explanation { font-size: smaller; }
	.yag-settings .label { display: inline-block; width: 100px; }
</style>
<div class="yag-settings">
	<div id="icon-options-general" class="icon32"></div>
	<h2>yaGlossary Options</h2>
	<br />
	<div style="clear:both;"></div>
	<div class="widefat">
		<div class="yag_message"></div>
		<form name="yag_settings_form" id="yag_settings_form" style="padding: 5px">
			<p>
				 <?php wp_nonce_field('yag_settings_verify','yag_settings_verify'); ?>
				<input class='button-primary  submitbutton' type='submit' name='Save' value='<?php _e('Save Options'); ?>' id='submitbutton' />
			</p>
			<h3>Which Pages</h3>
			<ul class="yag">
				<li style="border-bottom: 1px solid #bdbdbd">
					<input type="hidden" name="yag_on_zero_pages" id="yag_on_zero_pages" value="" />
					<input
						type="checkbox"
						name="yag_on_page[]"
						value="all"
						id="yag_on_all_page"
						<?php echo ( in_array( 'all', $yag_settings['yag_on_page'] ) ) ? 'checked="checked"': NULL ?>
					/>
					<label for="yag_on_all_page">All Pages</label>
				</li>
			</ul>
			<div style="clear:both;"></div>
			<ul class="yag">
			<?php foreach ( $pages as $page ): ?>
				<li>
					<input
						type="checkbox"
						name="yag_on_page[]"
						value="<?php echo $page->post_name ?>"
						class="yag_on_page"
						<?php if ( in_array($page->post_name, $yag_settings['yag_on_page'] ) ): ?>
						checked = "checked"
						<?php endif; ?>
						id="yag_on_page_<?php echo $page->post_name ?>" />
					<label
						for="yag_on_page_<?php echo $page->post_name?>">
							<?php echo $page->post_title ?>
						</label>
				</li>
			<?php endforeach; ?>
			</ul>
			<div style="clear:both;"></div>
			<h3>Styling</h3>
			<div style="width:40%; float: left">
				<div class="label">
					<label for="style_background">Background Color: </label>
				</div>
				<input
						class="yag_style_picker_input"
						id="style_background"
						type="text"
						value="<?php echo $yag_settings['pretty_pretty_colors']['style_background']?>"
						name="style_background"
						rel="colorpicker_backgound"
					/>
					<div class="yag_style_picker" id="colorpicker_backgound">asdf</div>
				<div style="clear:both;"></div>
					<div class="label">
						<label for="style_color">Text Color: </label>
					</div>
					<input
						class="yag_style_picker_input"
						id="style_color"
						type="text"
						value="<?php echo $yag_settings['pretty_pretty_colors']['style_color']?>"
						name="style_color"
						rel="colorpicker_color"
						/>
					<div class="yag_style_picker" id="colorpicker_color" rel="style_color"></div>
				<div style="clear:both;"></div>
					<div class="label">
						<label for="style_border_color">Border Color: </label>
					</div>
					<input
						class="yag_style_picker_input"
						id="style_border_color"
						type="text"
						value="<?php echo $yag_settings['pretty_pretty_colors']['style_border_color']?>"
						name="style_border_color"
						rel="colorpicker_border_color"
						/>
					<div class="yag_style_picker" id="colorpicker_border_color" rel="style_border_color"></div>
			</div>
				<div style="width:55%;float:right;padding-top:2%;">
					<div id="yag_example_container">
						Ipsome gipsom gloria idaho et all.
						Tu eta blurbeus uno gracias.
						Wait, what?
					</div>
				</div>
			<div style="clear:both;"></div>
		<div style="clear:both;"></div>
		<h3>Match / Replace Type</h3>
			<input type="checkbox" value="1" name="non_english_words" id="non_english_words" <?php echo ( $yag_settings['non_english_words'] ) ? 'checked="checked"' : NULL ?> />
			<label for="non_english_words">Glossary contains non-english words</label>
			<div class="explanation">This will change the way the find / replace functionality works. By making this selection, the find / replace feature will be less efficient, but will work with non-english characters.</div>
		<p>
			<input type="hidden" name="action" value="yag_option_save" />
			<input class='button-primary submitbutton' type='button' name='Save' value='<?php _e('Save Options'); ?>' id='submitbutton' />
		</p>
		<div class="yag_message"></div>
		</form>
	</div>
</div>
<script type="text/javascript">

   jQuery(document).ready(function($) {

	   var saving_option_text = $('.submitbutton').val();

   		$('.submitbutton').click(function(){

	   		$('.submitbutton').val('Saving');

	   		$('.yag_message').html('Your Options are being saved.');
   			$.post(
   				ajaxurl,
   				jQuery('#yag_settings_form').serialize(),
   				function(data){
   					$('.yag_message').html(data);
   					$('.submitbutton').val('Save Options');
   				});
	   		return false;
   		});

     $('.yag_style_picker').hide();

     $('.yag_style_picker_input').focus( function(){
			var element = $(this).attr('rel');
				var val_input = this;
				jQuery('.yag_style_picker').hide();
				jQuery('#' + element ).fadeIn();
				$.farbtastic( $('#' + element), function(a) { $(val_input).val(a); yag_update_example(); });
     });

     function yag_update_example(){
	     $('#yag_example_container').attr('style', 'color:'+$('#style_color').val()+';background-color:'+$('#style_background').val()+';border-color:'+$('#style_border_color').val()+';');
     }

	 $('#yag_on_all_page').click(function(){
		 	if( jQuery(this).attr('checked') == 'checked') { jQuery('input.yag_on_page').attr('checked', true); }
			else { jQuery('input.yag_on_page').attr('checked', false);}
		});

	$('.yag_on_page').change(function(){
		var count = 0;
		$('.yag_on_page').each(function(){
			if( $(this).attr('checked') == 'checked') { count = count + 1; }
		});
		if ( count < 1 ) { $('#yag_on_zero_pages').val(1); }
		else { $('#yag_on_zero_pages').val(''); }
	});
});
 </script>

<?php
	}
}
?>
