<?php

declare(strict_types=1);

namespace Includes\Services;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

class AssetsService implements PluginServiceInterface
{
    private static $instance;
    public function initialize()
    {
        add_action('init', [$this, 'register']);
    }

    public function register()
    {

        $this->registerStyles();
        $this->registerScripts();
        $this->localizeScripts();
        $this->instantiate();
    }

    public static function instance(): AssetsService
    {
        if (empty(AssetsService::$instance)) {
            AssetsService::$instance = new AssetsService();
        }

        return AssetsService::$instance;
    }

    public function enqueueScripts(array $scripts)
    {
        // Make sure that AssetsService intance is instantiated
        if (empty(AssetsService::$instance)) {
            throw new Exception("Invalid AssetsService instance.");
        }

        // Make sure that scripts has been passed correctly
        if (empty($scripts)) {
            throw new Exception("Error: Empty scripts passed. Expected array of valid string-formatted scripts");
        }

        foreach ($scripts as $script) {
            wp_enqueue_script($script);
        }
    }

    public function enqueueStyles(array $styles)
    {
        // Make sure that the scripts is not empty and the AssetsService intance is instantiated
        if (empty($styles) || empty(AssetsService::$instance)) {
            return;
        }

        foreach ($styles as $style) {
            wp_enqueue_style($style);
        }
    }

    private function instantiate()
    {
        AssetsService::$instance = new AssetsService();
    }

    private function registerStyles()
    {

        wp_register_style('cerv-resource-style', Config::get('pluginAssetsUrl') . '/css/cerv-resource.css', [], '1.0.0');
        wp_register_style('cerv-modal-style', Config::get('pluginAssetsUrl') . '/css/cerv-modal.css', [], '1.0.0');
    }

    private function registerScripts()
    {
        wp_register_script('cerv-resource-list', Config::get('pluginAssetsUrl') . '/js/main.js', [ 'jquery' ], '1.0.0', false);
    }

    private function localizeScripts()
    {
        wp_localize_script('cerv-resource-list', 'cervObj', [ 'api_endpoint' => Config::get('defaultAPIEnpoint') ]);
    }
}
