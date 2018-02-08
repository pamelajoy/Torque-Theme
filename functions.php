<?php
/**
 * torque functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package torque
 */

if ( ! function_exists( 'tq_theme_prefix_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tq_theme_prefix_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on torque, use a find and replace
		 * to change 'tq_theme_prefix' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tq_theme_prefix', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'tq_theme_prefix' ),
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
		add_theme_support( 'custom-background', apply_filters( 'tq_theme_prefix_custom_background_args', array(
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
add_action( 'after_setup_theme', 'tq_theme_prefix_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tq_theme_prefix_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tq_theme_prefix_content_width', 640 );
}
add_action( 'after_setup_theme', 'tq_theme_prefix_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tq_theme_prefix_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tq_theme_prefix' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'tq_theme_prefix' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tq_theme_prefix_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
if (! function_exists('tq_theme_prefix_custom_script_init') ){  
  function tq_theme_prefix_custom_script_init(){

  	// navigation.js
		// skip-link-focus-fix.js
  	wp_register_script( 'scripts', get_template_directory_uri().'/js/scripts.min.js', array( 'jquery' ), '', true );
  	wp_enqueue_script( 'scripts' );

  	// Compiled and minified style sheet
  	wp_register_style( 'style', get_stylesheet_directory_uri().'/style.min.css' );
  	wp_enqueue_style( 'style' );

  	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

  }
}
add_action( 'wp_enqueue_scripts', 'tq_theme_prefix_custom_script_init' );

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
if (! function_exists('tq_theme_prefix_my_custom_login') ){
	function tq_theme_prefix_my_custom_login() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/custom-login-style.css" />';
	}
}
add_action('login_head', 'tq_theme_prefix_my_custom_login');
// Link the logo to the home of our website
if (! function_exists('tq_theme_prefix_my_login_logo_url') ){
	function tq_theme_prefix_my_login_logo_url() {
		return get_bloginfo( 'url' );
	}
}
add_filter( 'login_headerurl', 'tq_theme_prefix_my_login_logo_url' );
// Change the title text
if(! function_exists('tq_theme_prefix_my_login_logo_url_title') ){
	function tq_theme_prefix_my_login_logo_url_title() {
		return 'Torque Theme';
	}
}
add_filter( 'login_headertitle', 'tq_theme_prefix_my_login_logo_url_title' );

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

// /**
//  * Bootstrap
//  */
// if (! function_exists(tq_theme_prefix_vendor_script_init) ){
//   function tq_theme_prefix_vendor_script_init() {

//     $bootstrap = apply_filters('torque_include_bootstrap', 0);

//     if ( $bootstrap ){

//     	// Boostrap requires latest version of jQuery
// 	  	wp_deregister_script('jquery');
// 	  	wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js');
// 	  	wp_enqueue_script('jquery');

// 	  	// Popper is a Boostrap dependency
// 	  	wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js', array( 'jquery'
// 	  	 ), '', true);
// 	  	wp_enqueue_script('popper');

// 	  	// Boostrap minified javascript
// 	  	wp_register_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js', array( 'jquery' ), '', true);
// 	  	wp_enqueue_script('bootstrap');

// 	  	// Boostrap uses the Font Awesome icon library
// 	  	wp_register_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
// 	  	wp_enqueue_style( 'font-awesome' );
	  	
// 	  	// Boostrap minified css
// 	  	wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' );
// 	  	wp_enqueue_style( 'bootstrap' );

// 	  	// Bootstrapify the WordPress Menu
// 			require_once(get_template_directory() . '/inc/bs4navwalker.php');
// 	  }

//   }
// }
// add_action( 'wp_enqueue_scripts', 'tq_theme_prefix_vendor_script_init' );

/*
 * Allow SVG Upload
 */
if ( ! function_exists('tq_theme_prefix_mime_types') ) :
  function tq_theme_prefix_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
endif;
add_filter('upload_mimes', 'tq_theme_prefix_mime_types');