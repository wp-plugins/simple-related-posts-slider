<?php
/**
 * @package Simple_Related_Posts_Slider
 * @version 1.21
 */
/*
Plugin Name: Simple Related Posts Slider 
Plugin URI: http://simple-related-posts.com/
Description: Simple Related Posts Slider is a very simple plugin that adds a slider containing related articles to the bottom of your wordpress posts. 
Author: Josiah Mann
Version: 1.21
Author URI: http://josiahmann.com/
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

    
class Simple_Related_Posts_Slider {
	 
	public function __construct() {

	    add_action('wp_footer', array($this, 'load_resources'));

	}

	public function get_thumbnail_as_bg(){
		global $post;
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 300,500 ), false, '' );
		return $src[0];
	}



	public function generate_html() {

		global $post;
		$options = get_option( 'srps_settings' );
		$tags = wp_get_post_tags($post->ID);
		$i = 0;
		if ($tags) {
			$tag_ids = array();			
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				$related = array(
					'tag__in' => $tag_ids,
					'post__not_in' => array($post->ID),
					'post_type' => 'post',
					'posts_per_page'=>12, // Number of related posts that will be shown.
					'ignore_sticky_posts'=>1,
				    'meta_key'    => '_thumbnail_id',
				);

			$srp_query = new WP_Query($related);
			$html = '<div class="srps" id="srps_cats">';

			// The Loop
			if ( $srp_query ->have_posts() ) {
				while ( $srp_query->have_posts() ) {
					$srp_query->the_post();
					if( $i < 1){
						if( isset( $options['srps_title'] ) ) { 
							$html .= '<h4 class="srps_title">' . $options['srps_title'] . '</h4>';
						} 
						$html .= '<div class="srps_slider">';
					}
					$html .= '<div class="srps_article">';
					$html .= '<a href="' . get_the_permalink() . '">';
					$html .= '<div class="srps_thumb" style="background-image:url(' . $this->get_thumbnail_as_bg() . ');"></div></a>';
					$html .= '<h5 class="srps_article_title"><a class="srps_article_title_link" href="' . get_the_permalink() . '">' . get_the_title() . '</a></h5><br/>';
					$html .= '</div>';
					$i++;
				}
				$html .= '</div><div class="clearfix"></div></div>';
			} 
			/* Restore original Post Data */
			wp_reset_query();
		} else {
			
			$categories = get_the_category();
			if ($categories){
				$category = $categories[0];
				$cat_ID = $category->cat_ID;
			} else {
				$cat_ID = '';
			}

			$related = array(
					'cat' => $cat_ID,
					'post__not_in' => array($post->ID),
					'post_type' => 'post',
					'posts_per_page'=>12, // Number of related posts that will be shown.
					'ignore_sticky_posts'=>1,
				    'meta_key'    => '_thumbnail_id',
				);

			$srp_query2 = new WP_Query($related);

			$html = '<div class="srps" id="srps_cats">';
			// The Loop
			if ( $srp_query2->have_posts() ) {
				while ( $srp_query2->have_posts() ) {
					$srp_query2->the_post();
					if( $i < 1){
						if( isset( $options['srps_title'] ) ) { 
							$html .= '<h4 class="srps_title">' . $options['srps_title'] . '</h4>';
						} 
						$html .= '<div class="srps_slider">';
					}
					$html .= '<div class="srps_article">';
					$html .= '<a href="' . get_the_permalink() . '">';
					$html .= '<div class="srps_thumb" style="background-image:url(' . $this->get_thumbnail_as_bg() . ');"></div></a>';
					$html .= '<h5 class="srps_article_title"><a class="srps_article_title_link" href="' . get_the_permalink() . '">' . get_the_title() . '</a></h5><br/>';
					$html .= '</div>';	
					$i++;
				}
				$html .= '</div><div class="clearfix"></div></div>';
			} 
			/* Restore original Post Data */
			wp_reset_query();

		}


		return $html;
	}

	public function load_resources() {

		wp_register_style( 'simple-related-posts.min.css', plugins_url( '/css/simple-related-posts.min.css' , __FILE__ ), array(), '1.0' );
		wp_enqueue_style( 'simple-related-posts.min.css');

		wp_register_script( 'slick.js', plugins_url( '/js/slick.min.js', __FILE__) , array('jquery'), '1.0' );
		wp_enqueue_script( 'slick.js' );


		wp_register_script( 'simple-slider-init.js', plugins_url('/js/simple-slider-init.js' , __FILE__ ), array('jquery'), '1.0' );
		wp_enqueue_script( 'simple-slider-init.js' );

	}

}


class Simple_Related_Posts_Slider_Admin {
 	
 	public function __construct(){
 		add_action( 'admin_menu', array($this, 'srps_add_admin_menu') );
		add_action( 'admin_init', array($this, 'srps_settings_init') );
	}

	public function srps_add_admin_menu(  ) { 

		add_submenu_page( 
			'options-general.php',
			'Simple Related Posts Slider', // Page Title
			'Simple Related Posts Slider', // Menu Title
			'manage_options', // User Capability
			'simple_related_posts_slider', // Menu Slug
			array($this, 'srps_options_page' ) , // function
			99981
		);

	}


	public function srps_settings_init(  ) { 

		register_setting( 
			'pluginPage', // Option Group Name
			'srps_settings' // The option name to sanitize 
		);

		add_settings_section(
			'srps_pluginPage_section', // ID
			__( 'General Options', 'wordpress' ), // Title 
			array($this, 'srps_settings_section_callback'), // Callback Function
			'pluginPage' // Page this is attached to
		);

		add_settings_field( 
			'srps_checkbox_field', // ID
			__( 'Disable plugin', 'wordpress' ), // Title
			array($this,'srps_checkbox_field_render'),  // Callback Function
			'pluginPage', // Page
			'srps_pluginPage_section' // Section this setting is attached to
		);
		
		add_settings_field( 
			'srps_title', // ID
			__( 'Title to display above related posts (if any).', 'wordpress' ), // Title
			array($this,'srps_title_callback'),  // Callback Function
			'pluginPage', // Page
			'srps_pluginPage_section' // Section this setting is attached to
		);

	}


	public function srps_checkbox_field_render(  ) { 

		$options = get_option( 'srps_settings' );?>
		<label><input type='checkbox' name='srps_settings[srps_checkbox_field]' <?php if( isset( $options['srps_checkbox_field'] ) ) {  checked( $options['srps_checkbox_field'], 1 ); }?> value='1'>  Simple Related Posts Slider is automatically added by default to the bottom of your single Wordpress posts.<br> If you would like to add it manually instead, check here and then save your changes.</label>		
		<?php
		if( isset( $options['srps_checkbox_field'] ) ) { ?>

			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('#show_manual_install').show();
					jQuery('input[name="srps_settings[srps_checkbox_field]"]').click(function(){
						jQuery('#show_manual_install').toggle();
					});
				});

			</script>
	
		<?php } else { ?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('input[name="srps_settings[srps_checkbox_field]"]').click(function(){
						jQuery('#show_manual_install').toggle();
					});
				});
			</script>
		<?php }


	}


	public function srps_title_callback(  ) { 
			$options = get_option( 'srps_settings' );?>
			<label><input type='text' class="large" name='srps_settings[srps_title]' value="<?php if( isset( $options['srps_title'] ) ) { echo  $options['srps_title']; }?>" placeholder="Related Articles"> </label>
	<?php
	}

	public function srps_settings_section_callback(  ) { 

	}


	public function srps_options_page(  ) { 

		?>
		<form action='options.php' method='post'>
			
			<h2>Simple Related Posts Slider</h2>
			
			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );?>
			<div id="show_manual_install" style="display: none;">
				<h4>To manually install, just insert this PHP snippet directly into the template file where you want it to display. </h4>
				<p>
					<code>&lt;?php srps(); ?&gt;</code>
				</p>
			</div>
			<?php submit_button();?>

		</form>
		<?php

	}



}




function add_slider_automatically($the_content){
	$options = get_option( 'srps_settings' );
	if( !isset( $options['srps_checkbox_field'] ) ) {
		if ( is_singular('post') && is_main_query() ){
			$myslider = new Simple_Related_Posts_Slider();
			$the_content = $the_content . $myslider->generate_html();
			return $the_content;
		} else {
			return $the_content;
		}
	}
	else {
		return $the_content;
	}
}
add_filter('the_content', 'add_slider_automatically');


function srps(){
	$options = get_option( 'srps_settings' );

	if( isset( $options['srps_checkbox_field'] ) ) {
		$myslider = new Simple_Related_Posts_Slider();
		echo $myslider->generate_html();
	}
	
}


$obj  = new Simple_Related_Posts_Slider_Admin();




