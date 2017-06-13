<?php
/*
Plugin Name: Sample Plugin
Description: A template structure for building wordpress plugins. It resenbles to some extent MVC, but not entirely.
Version:     Avram.Iancu
Author:      Grigore Alexandru Jucan
Author URI:  http://www.jalex.eu
License:     Handle with care.
Domain Path: /sample-plugin-domain
*/

include 'autoloader.php';

register_activation_hook( __FILE__,       array('SamplePlugin\\Service\\Wizard', 'activate'));
register_deactivation_hook( __FILE__,     array('SamplePlugin\\Service\\Wizard', 'deactivate'));

/**
 * Registering the rewrite rules and the query variables. Using the router for this. Keeping it organized.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

add_action('init',              array(SamplePlugin\Service\Router::getInstance(),             'rewriteRules'));
//add_filter('query_vars',    array(SamplePlugin\Service\Router::getInstance(), 'queryVars'));
add_action('parse_request',     array(SamplePlugin\Service\Router::getInstance(),             'parseRequest'));
add_action('plugins_loaded',    array(SamplePlugin\Core\PageTemplateInjector::getInstance(),  'injectTemplates' ) );

