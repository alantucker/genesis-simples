<?php

//* This will bring in the Genesis Parent files needed:
include_once( get_template_directory() . '/lib/init.php' );

//* We tell the name of our child theme
define( 'Child_Theme_Name', __( 'Simples', 'simples' ) );

//* We tell the web address of our child theme (More info & demo)
define( 'Child_Theme_Url', 'http://www.alantucker.co.uk' );

//* We tell the version of our child theme
define( 'Child_Theme_Version', '1.0' );

//* Add HTML5 markup structure from Genesis
add_theme_support( 'html5' );

//* Add HTML5 responsive recognition
add_theme_support( 'genesis-responsive-viewport' );

//* Force full-width-content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'sp_load_google_fonts' );
function sp_load_google_fonts() {
	wp_enqueue_style( 'google-font-roboto', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700', array(), CHILD_THEME_VERSION );
}

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] - Alan Tucker</a>';
	return $creds;
}



//* Custom footer, please leave in to show your support or send a paypal donation to alan.tucker@gmail.com
add_action( 'genesis_after_footer', 'custom_footer' );
function custom_footer() {
	echo '<div class="simples">Simples theme by <a href="http://www.alantucker.co.uk?ref='.$_SERVER['HTTP_HOST'].'" title="WordPress Designer &amp; Developer" target="_blank">Alan Tucker</a></div>';
}

add_action( 'genesis_before_content', 'category_info' );
function category_info() {
	if ( is_category() ) {
		echo '<div class="archive-info"><h2 class="archive-title">Category / <span>'.single_term_title('',false).'</span></h2></div>';
		//echo term_description();
	}
	if ( is_tag() ) {
		echo '<div class="archive-info"><h2 class="archive-title">Tag / <span>'.single_term_title('',false).'</span></h2></div>';
		//echo term_description();
	}
}

//* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
  if ( ! is_singular( 'post' ) )  return;
	the_post_thumbnail('post-image');
}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
	if ( !is_page() ) {
		$post_meta = '[post_categories before=""] [post_tags before=""]';
		return $post_meta;
	}
}

//* Customize the post info function
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	if ( !is_page() ) {
		$post_info = '[post_date format="F jS, Y"]';
		return $post_info;
	}
}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav', 12 );

//* Remove the primary sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

// Move image above post title
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

//* Position post info above post title
remove_action( 'genesis_entry_header', 'genesis_post_info', 12);
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );
