<?php

if ( ! class_exists( 'Timber' ) ) {
  add_action( 'admin_notices', function() {
      echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
  return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

  function __construct() {
    add_theme_support( 'post-formats' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_filter( 'timber_context', array( $this, 'add_to_context' ) );
    add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );

    add_action('widgets_init', array($this, 'sidebar_widgets_init'));

    parent::__construct();
  }

  function sidebar_widgets_init() {
    register_sidebar(array(
      'name'          => 'Site Sidebar',
      'id'            => 'site_sidebar',
      'before_widget' => '<div class="site-sidebar-widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="site-sidebar-widget-title">',
      'after_title'   => '</div>',
    ));
  }

  function register_post_types() { }
  function register_taxonomies() { }

  function add_to_context( $context ) {
    $context['menu'] = new TimberMenu();
    $context['site'] = $this;
    $context['sidebar'] = Timber::get_widgets('site_sidebar');
    return $context;
  }

  function add_to_twig( $twig ) {
    $twig->addExtension( new Twig_Extension_StringLoader() );
    return $twig;
  }

}

new StarterSite();
