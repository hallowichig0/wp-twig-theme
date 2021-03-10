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
$context['sidebar_blog'] = Timber::get_widgets('sidebar-blog');
$context['post'] = new Timber\Post();
$templates = array( 'front-page.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'index.twig' );
}
Timber::render( $templates, $context );