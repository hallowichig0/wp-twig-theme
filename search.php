<?php
/**
 * The template for displaying search results pages
 * 
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Bootstrap4
 */
global $paged;

if ( ! isset( $paged ) || ! $paged ) {
    $paged = 1;
}
$templates = array( 'search.twig', 'archive.twig', 'index.twig' );

$context = Timber::context();
$context['sidebar_blog'] = Timber::get_widgets('sidebar-blog');
$context['posts'] = new Timber\PostQuery();
Timber::render( $templates, $context );