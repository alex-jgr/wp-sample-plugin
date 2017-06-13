<?php
namespace SamplePlugin\Core;

use SamplePlugin\Core\Singleton;
use SamplePlugin\Service\Renderer;

abstract class Controller extends Singleton
{
    protected $query;
    
    /**
     * @var array Access control list. Must contain controller actions as keys and arrays of user roles as values.
     */
    protected   $acl = array();
    
    protected   $errors;
    
    protected   $content;
    protected   $context;
    protected   $template;


    private     $js_files   = array();
    private     $css_files  = array();

    public function setQuery($query)
    {
        $this->query = $query;
    }
    public function setParams($params)
    {
        if (!is_array($params)) {
            $this->query['action'] = $params;
        } else {
            $this->setQuery($params);
        }
    }
    
    public function getAction()
    {
        return $this->query['action'];
    }
    
    public function getParam($param)
    {
        return $this->query[$param];
    }
    
    public function authorize($action)
    {
        $this->user = wp_get_current_user();
        $roles      = get_user_meta($this->user->ID, 'role');
        
        if (! empty($this->acl[$action])) {
            $authorized = array_intersect($roles, $this->acl[$action]);
            if (! count($authorized)) {
                $this->errors = array('message' => 'Unauthorized', 'code' => 403);
            }
        }
    }

    public function post($param = NULL)
    {
        if ($param) {
            return isset($_POST[$param]) ? $_POST[$param] : NULL;
        } else {
            return $_POST;
        }
    }
    
    public function get($param = NULL)
    {
        if ($param) {
            return isset($_GET[$param]) ? $_GET[$param] : NULL;
        } else {
            return $_GET;
        }
    }
    
    public function addJsFile($key, $path)
    {
        $this->js_files[$key] = $path;
    }
    
    public function addCssFile($key, $path)
    {
        $this->css_files[$key] = $path;
    }

    public function dispatch()
    {
        $action = $this->getAction() . 'Action';
        $this->authorize($action);
        if ($this->errors) {
            
        } else {
            return call_user_func( array( $this, $action) );
        }
    }

    public function beforeShowContent(){}
    
    public function showContent()
    {
        if (!$this->template) {
            $this->template = str_replace('SamplePlugin\\Controller\\', '', get_class($this)) . DIRECTORY_SEPARATOR . $this->getAction();
        }
        
        $this->content = Renderer::getInstance()->render($this->template, $this->context);
        
        $this->beforeShowContent();
        foreach ($this->js_files as $key => $js_file) {
            wp_enqueue_script('sample-plugin-' . $key, '/' . PLUGINDIR . '/sample-plugin/js/' . $js_file, array(), FALSE, TRUE);
        }
        foreach ($this->css_files as $key => $css_file) {
            wp_enqueue_style('sample-plugin-' . $key,    '/' . PLUGINDIR . '/sample-plugin/style/' . $css_file);
        }
        
        echo $this->content;
    }
    
    public function indexAction(){}
}
