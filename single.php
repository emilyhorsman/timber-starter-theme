<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

$categories = array_map(function($category) {
  return $category->ID;
}, $post->get_terms('category'));

if (count($categories) > 0) {
  $args = array(
    'post_type'    => 'post',
    'numberposts'  => 3,
    'post__not_in' => array($post->ID),
    'tax_query'    => array(
      'taxonomy'   => 'category',
      'field'      => 'id',
      'terms'      => $categories,
      'operator'   => 'IN',
    ),
  );

  $context['related'] = Timber::get_posts($args);
}

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
