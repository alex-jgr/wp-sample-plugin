<?php
class Loader
{
    protected static $instance;
    
    protected $bootstrap;
    
    public $vendorFiles;
    
    public static function getInstance() {
        if (! static::$instance ) {
            static::$instance = new Loader();
        }
        return static::$instance;
    }
    
    public function __construct() {
        $this->bootstrap = include 'bootstrap.php';
    }
    
    public function getPageTemplates ()
    {
        return $this->bootstrap['pageTemplates'];
    }

    public function getClass ($namespace)
    {
        return isset($this->bootstrap['autoload'][$namespace]) ? $this->bootstrap['autoload'][$namespace] : NULL;
    }
            
    public function getVendorFolder ()
    {
        if (! $this->vendorFiles ) {
            $this->vendorFiles = scandir(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor');
        }
        return $this->vendorFiles;
    }
    
    public function getFromVendor ($namespace)
    {
        $name = explode('\\', $namespace);
        
        if (count($name)) {
            $namespace = $name[0];
        }
        
        $dir        = dirname(__FILE__). DIRECTORY_SEPARATOR. 'vendor' . DIRECTORY_SEPARATOR . strtolower($namespace);
        $php_file   = $dir . '.php';
        $autoloader = $dir . DIRECTORY_SEPARATOR . 'Autoloader.php';
        
        if (is_file($php_file)) {
            require_once $php_file;
        } elseif(is_file($autoloader)) {
            require_once $autoloader;
        } elseif (is_dir($dir)) {
            $this->recursiveDirLoad($dir);
        }
    }
    
    public function recursiveDirLoad($dir)
    {
        $content = scandir($dir);
        
        foreach ($content as $file_name) {
            $path = $dir . DIRECTORY_SEPARATOR . $file_name;
            if ($file_name != '.' && $file_name != '..') {
                if (is_dir($path)) {
                    $this->recursiveDirLoad($path);
                } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    require_once $path;
                }
            }
        }
    }
    
    public function getClassPath($className)
    {
        $classFile = $this->getClass($className);
        
        if ($classFile) {
            require_once dirname(__FILE__). $classFile . '.php';
        } else {
            $this->getFromVendor($className);
        }
    }
}