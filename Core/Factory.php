<?php
namespace SamplePlugin\Core;

class Factory
{
    public static function getInstance ($class, $params = NULL)
    {
        $instance = $class::getInstance();
                
        if ($params) {
            $instance->setParams($params);
        }
        
        return $instance;
    }
}
