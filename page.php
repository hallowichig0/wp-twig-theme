<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 * 
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );