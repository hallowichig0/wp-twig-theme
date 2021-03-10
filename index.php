<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * 
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */

$templates = array( 'index.twig' );
$context = Timber::context();
$context['sidebar_blog'] = Timber::get_widgets('sidebar-blog');
$context['posts'] = new Timber\PostQuery();
if ( is_home() && (locate_template( 'home.php' ) || locate_template( 'front-page.php' )) ) {
	array_unshift( $templates, 'front-page.twig', 'home.twig' );
}
Timber::render( $templates, $context );