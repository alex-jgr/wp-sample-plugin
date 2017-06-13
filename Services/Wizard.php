<?php
namespace SamplePlugin\Service;

/**
 * The vendor autoloader is not PSR-4, so we are importing the library by including a file which uses their autoloader
 */
include dirname(__DIR__) . '/vendor/less.php/lessc.inc.php';

class Wizard
{
    public static function activate()
    {
        global $user_ID;
        
        // Visit Rural Page -- for the routes rewriting
        $page       = get_page_by_title( 'Sample Plugin Domain', OBJECT, 'page' );
        $page_ID    = $page ? $page->ID : NULL;

        if (! $page_ID) {
            $new_page = array(
                'post_title'    => 'Sample Plugin Domain',
                'post_content'  => '[sample_plugin_shortcode]',
                'post_status'   => 'publish',
                'post_date'     => date('Y-m-d H:i:s', time() - 7200),
                'post_author'   => $user_ID,
                'post_type'     => 'page',
                'page_template' => 'default'
            );
            $page_ID = wp_insert_post($new_page);
        }
        
        flush_rewrite_rules();
        
        Wizard::updateStyleFile();
    }
    
    public static function updateStyleFile()
    {
        $parser = new \Less_Parser(array( 'compress' => TRUE ));
        $parser->parseFile(dirname(__DIR__) . '/style/sample-plugin.less', site_url());
        file_put_contents(dirname(__DIR__) . '/style/sample-plugin.css', $parser->getCss());
    }

    public static function deactivate()
    {

    }
}
