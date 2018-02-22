<?php
/**
 * torque functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package torque
 */

if ( ! function_exists( 'tq_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tq_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on torque, use a find and replace
		 * to change 'tq' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tq', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'tq' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'tq_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'tq_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tq_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tq_content_width', 640 );
}
add_action( 'after_setup_theme', 'tq_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tq_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tq' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'tq' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tq_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
if (! function_exists('tq_custom_script_init') ){  
  function tq_custom_script_init(){

  	// navigation.js
		// skip-link-focus-fix.js
  	wp_register_script( 'scripts', get_template_directory_uri().'/js/scripts.min.js', array( 'jquery' ), '', true );
  	wp_enqueue_script( 'scripts' );

  	// Compiled and minified style sheet
  	wp_register_style( 'style', get_template_directory_uri().'/style.min.css' );
  	wp_enqueue_style( 'style' );

  	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

  }
}
add_action( 'wp_enqueue_scripts', 'tq_custom_script_init' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions. Enqueues /inc/customizer.js
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom login
 */
// Add custom css
if (! function_exists('tq_my_custom_login') ){
	function tq_my_custom_login() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/custom-login-style.css" />';
	}
}
add_action('login_head', 'tq_my_custom_login');
// Link the logo to the home of website
if (! function_exists('tq_my_login_logo_url') ){
	function tq_my_login_logo_url() {
		return get_bloginfo( 'url' );
	}
}
add_filter( 'login_headerurl', 'tq_my_login_logo_url' );
// Change the title text
if(! function_exists('tq_my_login_logo_url_title') ){
	function tq_my_login_logo_url_title() {
		return 'Torque Theme';
	}
}
add_filter( 'login_headertitle', 'tq_my_login_logo_url_title' );

/**
 * TGM Plugin Activation
 */
require_once(get_template_directory() . '/inc/tgm-plugin-activation.php');

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Bootstrap
 */
if (! function_exists('tq_vendor_script_init') ){
  function tq_vendor_script_init() {

    $bootstrap = apply_filters('tq_include_bootstrap', 0, $value);

    if ( $bootstrap ){

    	// Boostrap requires latest version of jQuery
	  	wp_deregister_script('jquery');
	  	wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js');
	  	wp_enqueue_script('jquery');

	  	// Popper is a Boostrap dependency
	  	wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js', array( 'jquery'
	  	 ), '', true);
	  	wp_enqueue_script('popper');

	  	// Boostrap minified javascript
	  	wp_register_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js', array( 'jquery' ), '', true);
	  	wp_enqueue_script('bootstrap');

	  	// Boostrap uses the Font Awesome icon library
	  	wp_register_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	  	wp_enqueue_style( 'font-awesome' );
	  	
	  	// Boostrap minified css
	  	wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' );
	  	wp_enqueue_style( 'bootstrap' );

	  	// Bootstrapify the WordPress Menu
			require_once(get_template_directory() . '/inc/bs4navwalker.php');
	  }

  }
}
add_action( 'wp_enqueue_scripts', 'tq_vendor_script_init' );

/*
 * Allow SVG Upload
 */
if ( ! function_exists('tq_mime_types') ) :
  function tq_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
endif;
add_filter('upload_mimes', 'tq_mime_types');

// Add a div around the_content, to style elements
if ( ! function_exists('tq_content_div') ) {

	function tq_content_div($content) {
	  $beforecontent = '<div class="content">';
	  $aftercontent = '</div>';
	  $fullcontent = $beforecontent . $content . $aftercontent;
	  
	  return $fullcontent;
	}

}
add_filter( 'the_content', 'tq_content_div' );

// Add page slug in body class
if ( ! function_exists('tq_add_slug_body_class') ) {
  function tq_add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
      $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
  }
}
add_filter( 'body_class', 'tq_add_slug_body_class' );
