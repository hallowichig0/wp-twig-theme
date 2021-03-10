<?php
/**
 * The template for displaying all single posts and attachments
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 * 
 * @package Bootstrap4
 */

$context = Timber::context();
$context['sidebar_blog'] = Timber::get_widgets('sidebar-blog');
$timber_post = new Timber\Post();
$context['post'] = $timber_post;

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}