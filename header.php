<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <main id="primary">
 * 
 * Third party plugins that hijack the theme will call wp_footer() to get the footer template.
 * We use this to end our output buffer (started in header.php) and render into the templates/page-plugin.twig template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootstrap4
 */

$GLOBALS['GlobalContext'] = Timber::context();
ob_start();