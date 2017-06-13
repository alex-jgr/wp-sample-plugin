<?php
namespace SamplePlugin\Service;
use SamplePlugin\Core\Service;

include dirname(__DIR__) . '/vendor/mustache.php';

/**
 * Description of Renderer
 *
 * @author admin
 */
class Renderer extends Service
{
    protected $engine;
    
    public function __construct(array $options = array()) {
        if (! isset($options['cache'])) {
            $options['cache'] = new \Khromov\Mustache_Cache\Mustache_Cache_WordPressCache();
        }
        if (!isset($options['loader'])) {
            $options['loader'] = new \Mustache_Loader_FilesystemLoader(dirname(__DIR__).'/mustache-templates');
        }
        if (!isset($options['partials_loader'])) {
            $options['partials_loader'] =  new \Mustache_Loader_FilesystemLoader(dirname(__DIR__).'/mustache-templates/partials');
        }
        $this->engine = new \Mustache_Engine($options);
    }
    
    public function render($template, $view) {
        return $this->engine->loadTemplate($template)->render($view);
    }
}
