<?php
namespace Includes\Services;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

class AssetsService implements PluginServiceInterface
{
    private static $instance;

	public function initialize()
	{
        add_action('init', array($this, 'register') );
    }

    public function register(){
        $this->registerStyles();
        $this->registerScripts();
        $this->localizeScripts();
        $this->instantiate();
    }    

    public static function getInstance(){
        if(AssetsService::$instance){
            return AssetsService::$instance;
        }

        return -1;
    }

    public function enqueueScripts(Array $scripts){
        // Make sure that the scripts is not empty and the AssetsService intance is instantiated
        if (empty($scripts) || empty(AssetsService::$instance))
            return -1;

        foreach ($scripts as $script) {
            wp_enqueue_script($script);
        }
    }

    public function enqueueStyles(Array $styles){
        // Make sure that the scripts is not empty and the AssetsService intance is instantiated
        if (empty($styles) || empty(AssetsService::$instance))
            return;

        foreach ($styles as $style) {
            wp_enqueue_style($style);
        }
    }

    private function instantiate(){
        AssetsService::$instance = new AssetsService();
    }

    private function registerStyles(){
        wp_register_style('cerv-resource-style', Config::get('pluginAssetsUrl') . '/css/cerv-resource.css');
        wp_register_style('cerv-modal-style', Config::get('pluginAssetsUrl') . '/css/cerv-modal.css');
    }

    private function registerScripts(){
        wp_register_script('cerv-resource-list', Config::get('pluginAssetsUrl') . '/js/main.js', array( 'jquery' ), '1.0.0', false);
    }

    private function localizeScripts(){
        wp_localize_script( 'cerv-resource-list', 'cervObj', array( 'api_endpoint' => Config::get('defaultAPIEnpoint') ) );
    }    
}
