<?php
namespace SamplePlugin\Service;

use SamplePlugin\Core\Factory;
use \SamplePlugin\Core\Service;

class Router extends Service
{
    protected $controller;
    protected $query;
    protected $pageID;
    
    protected $pageDate;
    
    public function __construct() {
        $page           = get_page_by_title( 'Sample Plugin Domain', OBJECT, 'page' );
        if ($page) {
            $this->pageID = $page->ID;
        
            $this->pageDate = array(
                'y' => substr($page->post_date, 0, 4),
                'm' => substr($page->post_date, 5, 2),
                'd' => substr($page->post_date, 8, 2)
            );
        }
        
        add_shortcode('sample_plugin_shortcode', array($this, 'done'));
    }

    public function rewriteRules()
    {
        global $wp_rewrite;
        
        switch ($wp_rewrite->permalink_structure) {
            case '/%year%/%monthnum%/%day%/%postname%/':
                add_rewrite_rule( 'sample-plugin-domain/([^/]*)/?([^/]*)?', 'index.php?year=' . $this->pageDate['y'] . '&monthnum=' . $this->pageDate['m'] . '&day=' . $this->pageDate['d'] . '&sample_plugin_page=$matches[1]&sample_plugin_query=$matches[2]', 'top');
                break;
            case '/%year%/%monthnum%/%postname%/':
                add_rewrite_rule( 'sample-plugin-domain/([^/]*)/?([^/]*)?', 'index.php?year=' . $this->pageDate['y'] . '&monthnum=' . $this->pageDate['m'] . '&sample_plugin_page=$matches[1]&sample_plugin_query=$matches[2]', 'top');
                break;
            case '/%postname%/':
                add_rewrite_rule( 'sample-plugin-domain/([^/]*)/?([^/]*)?', 'index.php?sample_plugin_page=$matches[1]&sample_plugin_query=$matches[2]', 'top');
                break;
            case '':
            case null:
                add_rewrite_rule( 'sample-plugin-domain/([^/]*)/?([^/]*)?', '?index.php?p=' . $this->pageID . '&sample_plugin_page=$matches[1]&sample_plugin_query=$matches[2]', 'top');
                break;
            default:
                add_rewrite_rule( 'sample-plugin-domain/([^/]*)/?([^/]*)?', get_option('visitrural_custom_rewrite'), 'top');
                break;
        }
        
        add_rewrite_tag( '%sample_plugin_page%', '([^&]+)' );
        add_rewrite_tag( '%sample_plugin_query%', '([^&]+)' );
    }
    

    public function parseRequest(&$wp)
    {
        if (isset($wp->query_vars['sample_plugin_page']) || $wp->request == 'sample-plugin-domain') {
            $wp->query_vars['post_type'] = 'page';
            $wp->query_vars['pagename']  = 'Sample Plugin Domain';
            
            if (empty($wp->query_vars['sample_plugin_page'])) {
                $wp->query_vars['sample_plugin_page'] = 'Index';
            }
            if (empty($wp->query_vars['sample_plugin_query'])) {
                $wp->query_vars['sample_plugin_query'] = 'index';
            }

            $this->controller   =  'SamplePlugin\\Controller\\' . $wp->query_vars['sample_plugin_page'];
            $this->query        = $wp->query_vars['sample_plugin_query'];
            
            add_action('the_post', array(Factory::getInstance($this->controller, $this->query), 'dispatch'));
        }          
        return $wp;
    }
    
    public function done()
    {
        if ($this->controller) {
            Factory::getInstance($this->controller)->showContent();
        }
    }
}
