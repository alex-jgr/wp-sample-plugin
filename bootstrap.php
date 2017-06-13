<?php
return array(
    'autoload' => array(
        'SamplePlugin\\Service\\Wizard'       => '/Services/Wizard',
        'SamplePlugin\\Service\\Router'       => '/Services/Router',
        'SamplePlugin\\Service\\Renderer'     => '/Services/Renderer',
        'SamplePlugin\\Service\\Secure'       => '/Services/Secure',
        
        'SamplePlugin\\Core\\Singleton'               => '/Core/Singleton',
        'SamplePlugin\\Core\\Controller'              => '/Core/Controller',
        'SamplePlugin\\Core\\Factory'                 => '/Core/Factory',
        'SamplePlugin\\Core\\Service'                 => '/Core/Service',
        'SamplePlugin\\Core\\PageTemplateInjector'    => '/Core/PageTemplateInjector',
        
        'SamplePlugin\\Controller\\Index'     => '/Controllers/Index',
        'SamplePlugin\\Controller\\Admin'     => '/Controllers/Admin',
        
        'Khromov\\Mustache_Cache\\Mustache_Cache_WordPressCache'     => '/vendor/Mustache_Cache_WordPressCache',
    ),
    
    'pageTemplates' => array(
        'sample-plugin-full.php' => 'Visit Rural Full'
    )
);