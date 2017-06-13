<?php

namespace SamplePlugin\Core;

use SamplePlugin\Core\Singleton;
/**
 * Adaptation of the example found at the following address
 * 
 * http://www.wpexplorer.com/wordpress-page-templates-plugin/
 * 
 * - minus the support for old WordPress versions
 *
 * @author admin
 */
class PageTemplateInjector extends Singleton
{
    protected $templates;
    
    public function injectTemplates()
    {
        $this->getTemplates();
        
        add_filter('theme_page_templates',  array( $this,   'addTemplates' ));
        add_filter('wp_insert_post_data',   array( $this,   'registerPluginTemplates' ));
        add_filter('template_include',      array( $this,   'viewPluginTemplate' ));
    }
    
    public function getTemplates()
    {
        if (!$this->templates) {
            $this->templates = \Loader::getInstance()->getPageTemplates();
        }
        return $this->templates;
    }
    
    public function addTemplates ( $posts_templates )
    {
        return array_merge( $posts_templates, $this->templates );
    }
    /**
    * Adds our template to the pages cache in order to trick WordPress
    * into thinking the template file exists where it doesn't really exist.
    */
    public function registerPluginTemplates($attributes)
    {
        // Create the key used for the themes cache
	$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

	// Retrieve the cache list. 
	// If it doesn't exist, or it's empty prepare an array
	$templates = wp_get_theme()->get_page_templates();
	if ( empty( $templates ) ) {
		$templates = array();
	} 

	// New cache, therefore remove the old one
	wp_cache_delete( $cache_key , 'themes');

	// Now add our template to the list of templates by merging our templates
	// with the existing templates array from the cache.
	// Add the modified cache to allow WordPress to pick it up for listing
	// available templates
	wp_cache_add( $cache_key,  array_merge( $templates, $this->templates ), 'themes', 1800 );

	return $attributes;
    }
    
    /**
    * Checks if the template is assigned to the page
    */
    public function viewPluginTemplate( $template )
    {
        // Get global post
	global $post;

	// Return template if post is empty
	if ( ! $post ) {
            return $template;
	}

	// Return default template if we don't have a custom one defined
	if ( ! isset( $this->templates[get_post_meta($post->ID, '_wp_page_template', true )] ) ) {
            return $template;
	} 

	$file = $this->baseDir . DIRECTORY_SEPARATOR . 'page-templates' . DIRECTORY_SEPARATOR . get_post_meta( $post->ID, '_wp_page_template', true);

	// Just to be safe, we check if the file exist first
	if ( file_exists( $file ) ) {
            return $file;
	} else {
            echo $file;
	}

	// Return template
	return $template;
    }
}
