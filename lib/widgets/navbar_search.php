<?php

class NavbarSearchWidget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'navbar_search_widget',
      'Navbar Search',
      array(
        'description' => 'Inline search form for navbar',
      )
    );
  }

  public function widget($args, $instance) {
    $context = array(
      'args'     => $args,
      'instance' => $instance,
    );

    Timber::render('widgets/navbar_search.twig', $context);
  }
}

