<?php
namespace SamplePlugin\Controller;

use SamplePlugin\Core\Controller;
use SamplePlugin\Service\Wizard;
use SamplePlugin\Service\Secure;

class Admin extends Controller
{
    public $js_files = array(
        'admin' => 'admin.js'
    );
    
    public function updateStyleAction()
    {
        Wizard::updateStyleFile();
    }
    
    public function apiSettingsAction()
    {
        $secureService  = Secure::getInstance();
        
        $apiKey     = $this->post('api_key');
        $apiSecret  = $this->post('api_secret');
        
        if ($apiKey) {
            $secureService->set('some_api_key', $apiKey);
        }
        
        if ($apiSecret) {
            $secureService->set('some_api_secret', $apiSecret);
        }
        
        $this->addCssFile('sample-plugin.css', 'sample-plugin.css');
        
        $this->context = array(
            'apiKey'    => $secureService->get('some_api_key'),
            'apiSecred' => $secureService->get('some_api_secret')
        );
    }
}
