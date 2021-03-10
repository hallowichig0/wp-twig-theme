<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 * 
 * Third party plugins that hijack the theme will call wp_footer() to get the footer template.
 * We use this to end our output buffer (started in header.php) and render into the view/page-plugin.twig template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootstrap4
 */

$context = $GLOBALS['GlobalContext']; // @codingStandardsIgnoreFile
if ( ! isset( $context ) ) {
	throw new \Exception( 'Timber context not set in footer.' );
}
$context['content'] = Timber::ob_get_contents();
ob_end_clean();
$templates = array( 'footer.twig' );
Timber::render( $templates, $context );