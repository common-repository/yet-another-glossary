<?php
if ( !class_exists( 'Yag_The_Class' ) ) {

	class Yag_The_Class
	{

		private $_yag_options;
		private $_yag_words;

		function __construct() {
			$this->_yag_options = get_option( 'yag_options' );
		}

		public function is_yag( $post_name ) {
			if ( $this->_yag_options['yag_on_page'] == 'all' ) {
				$this->get_yag_words();
				return TRUE;
			}

			if ( isset( $this->_yag_options['yag_on_page'] ) && count( $this->_yag_options['yag_on_page'] ) ) {
				if ( in_array( strtolower( $post_name ), $this->_yag_options['yag_on_page'] ) ) {
					$this->get_yag_words();
					return TRUE;
				}
			}

			return FALSE;
		}

		private function get_yag_words() {

			$yag_posts = get_posts(array('post_type' => YAG_POST_TYPE_NAME));
			
			foreach ( $yag_posts as $post ) {
			
				if ( isset( $this->_yag_options['non_english_words'] ) && $this->_yag_options['non_english_words'] )
					$this->_yag_words[$post->ID] 		=  strtolower( $post->post_title );
				else 
					$this->_yag_words[$post->ID] 		= '/ ' . strtolower( $post->post_title ) . ' /i';
			
				$this->yag_definitions[$post->ID] = $this->yag_up_definition( $post->post_title, $post->post_content );

				ksort($this->_yag_words);
				ksort($this->yag_definitions);
			}
		}

		private function yag_up_definition( $word, $definition ) {

			$html 	= array();
			$html[] = '	<a class=\'yag_word\'>' . $word . '</a> ';
			$html[] = '	<span class="yag_definition"> ' . $definition .' </span> ';
			return implode( "", $html );
		}

		public function yag_content( $content ) {
		
				if ( isset( $this->_yag_options['non_english_words'] ) && $this->_yag_options['non_english_words'] ) {

					foreach ( $this->_yag_words as $key => $word )
						$content = str_replace( $word, $this->yag_definitions[$key], $content );
					
					return $content . $this->append_css();
				} 
				else
					return preg_replace( $this->_yag_words, $this->yag_definitions, $content ) . $this->append_css();
				
		}

		private function append_css() {

			$color_options 	= $this->_yag_options['pretty_pretty_colors'];

			extract($color_options);

			$css 	  = array();
			$css[] 	= '<style>';
			$css[] 	= '.yag_definition{ text-align: center; position: absolute; margin: 15px; color: '.$style_color.'; background-color:'.$style_background.'; border-color:'.$style_border_color.'; padding: 5px; }';
			$css[] 	= '</style>';
			return implode("", $css);
		}
	}

}