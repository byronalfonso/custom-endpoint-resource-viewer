<?php

declare(strict_types=1);

namespace Includes\Services;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

class AssetsService implements PluginServiceInterface
{
    private static $instance;

    /**
     * Initializes all the functionality for the AssetsService
     *
     * @return void
     */
    public function initialize()
    {
        add_action('init', [$this, 'registerAssets']);
        $this->instantiate();
    }

    /**
     * Registers all the styles and scripts and localizes them
     *
     * @return void
     */
    public function registerAssets()
    {
        $this->registerStyles();
        $this->registerScripts();
        $this->localizeScripts();
    }

    /**
     * Returns instance of the AssetsService (singleton)
     *
     * @return void
     */
    public static function instance(): AssetsService
    {
        if (empty(AssetsService::$instance)) {
            AssetsService::$instance = new AssetsService();
        }

        return AssetsService::$instance;
    }

    /**
     * Enqueue Scripts within the registered scripts
     *
     * @return void
     */
    public function enqueueScripts(array $scripts)
    {
        // Make sure that AssetsService intance is instantiated
        if (empty(AssetsService::$instance)) {
            throw new \Exception("AssetsService is not properly initialized.");
        }

        // Make sure that scripts has been passed correctly
        if (empty($scripts)) {
            throw new \Exception("Error: Empty scripts passed. Expected array of valid string-formatted scripts");
        }

        $allowedScripts = ['cerv-resource-list'];

        foreach ($scripts as $script) {
            // Make sure that script is allowed and registered
            if (!in_array($script, $allowedScripts)) {
                throw new \Exception("Error: You are trying to enqueue a script that is not registered in the AssetsService.");
            }

            wp_enqueue_script($script);
        }
    }

    /**
     * Enqueue Styles within the registered styles
     *
     * @return void
     */
    public function enqueueStyles(array $styles)
    {
        // Make sure that AssetsService intance is instantiated
        if (empty(AssetsService::$instance)) {
            throw new \Exception("AssetsService is not properly initialized.");
        }

        // Make sure that styles has been passed correctly
        if (empty($styles)) {
            throw new \Exception("Error: Empty styles passed. Expected array of valid string-formatted styles");
        }

        $allowedStyles = ['cerv-resource-style', 'cerv-modal-style'];

        foreach ($styles as $style) {
            // Make sure that style is allowed and registered
            if (!in_array($style, $allowedStyles)) {
                throw new \Exception("Error: You are trying to enqueue a style that is not registered in the AssetsService.");
            }

            wp_enqueue_style($style);
        }
    }
    
    /**
     * Creates instance of the AssetsService (singleton)
     *
     * @return void
     */
    private function instantiate()
    {
        AssetsService::$instance = new AssetsService();
    }

    /**
     * Registers all allowed styles
     *
     * @return void
     */
    private function registerStyles()
    {

        wp_register_style('cerv-resource-style', Config::get('pluginAssetsUrl') . '/css/cerv-resource.css', [], '1.0.0');
        wp_register_style('cerv-modal-style', Config::get('pluginAssetsUrl') . '/css/cerv-modal.css', [], '1.0.0');
    }

    /**
     * Registers all allowed scripts
     *
     * @return void
     */
    private function registerScripts()
    {
        wp_register_script('cerv-resource-list', Config::get('pluginAssetsUrl') . '/js/main.js', [ 'jquery' ], '1.0.0', false);
    }

    /**
     * Localizes all allowed scripts and data
     *
     * @return void
     */
    private function localizeScripts()
    {
        wp_localize_script('cerv-resource-list', 'cervObj', [ 'api_endpoint' => Config::get('defaultAPIEnpoint') ]);
    }
}
