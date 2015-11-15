<?php

if ( ! class_exists( 'Timber' ) ) {
  add_action( 'admin_notices', function() {
      echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
  return;
}

Timber::$dirname = array('templates', 'views');

require_once(__DIR__ . '/lib/widgets/navbar_search.php');

class StarterSite extends TimberSite {

  function __construct() {
    add_theme_support( 'post-formats' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_filter( 'timber_context', array( $this, 'add_to_context' ) );
    add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );
    add_action( 'init', array( $this, 'register_menus' ) );

    add_action('wp_enqueue_scripts', array($this, 'scripts'));

    add_action('widgets_init', array($this, 'widget_locations_init'));
    add_action('widgets_init', function() {
      register_widget('NavbarSearchWidget');
    });

    parent::__construct();
  }

  function scripts() {
    wp_enqueue_script('jquery');
  }

  function widget_locations_init() {
    register_sidebar(array(
      'name'          => 'Site Sidebar',
      'id'            => 'site_sidebar',
      'before_widget' => '<div class="site-sidebar-widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="site-sidebar-widget-title">',
      'after_title'   => '</div>',
    ));

    register_sidebar(array(
      'name'          => 'Site Nav',
      'id'            => 'site_nav_widgets',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '',
      'after_title'   => '',
    ));
  }

  function register_post_types() { }
  function register_taxonomies() { }

  function register_menus() {
    register_nav_menu('main-nav-bar', __('Main Navbar'));
  }

  function add_to_context( $context ) {
    $context['site']        = $this;
    $context['nav_bar']     = new TimberMenu('main-nav-bar');
    $context['nav_widgets'] = Timber::get_widgets('site_nav_widgets');
    $context['sidebar']     = Timber::get_widgets('site_sidebar');
    return $context;
  }

  function add_to_twig( $twig ) {
    $twig->addExtension( new Twig_Extension_StringLoader() );
    $twig->addFunction( new Twig_SimpleFunction('columns', array($this, 'columns')));
    return $twig;
  }

  function columns($n) {
    return 12 / $n;
  }

}

new StarterSite();
