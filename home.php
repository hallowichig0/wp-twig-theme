<?php
/**
 * Template for displaying all blog post
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */

$templates = array( 'home.twig' );
$context = Timber::context();
$context['sidebar_blog'] = Timber::get_widgets('sidebar-blog');
$context['posts'] = new Timber\PostQuery();
Timber::render( $templates, $context );