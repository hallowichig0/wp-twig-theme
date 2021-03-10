<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Bootstrap4
 */

$context = Timber::context();
$context['page_title'] = 'Oops! That page can\'t be found.';
$context['page_body'] = 'It looks like nothing was found at this location. Maybe try one of the links below or a search?';
Timber::render( '404.twig', $context );