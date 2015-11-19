<?php
/**
 * Template Name: Fluid Page
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['base_template'] = 'base-fluid.twig';
$context['post'] = $post;
Timber::render('page.twig', $context);
