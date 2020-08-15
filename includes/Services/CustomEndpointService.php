<?php

declare(strict_types=1);

namespace Includes\Services;

use Includes\Config;
use Includes\Services\AssetsService;
use Includes\Managers\TemplateManager;
use Includes\Services\API\ResourceService;
use Includes\Interfaces\PluginServiceInterface;

class CustomEndpointService implements PluginServiceInterface
{
    private $defaultEndpoint;

    /**
     * Initializes all the functionality for the CustomEndpointService
     *
     * @return void
     */
    public function initialize()
    {
        $this->defaultEndpoint = Config::get('defaultEndpoint');
        add_action('init', [$this, 'customEnpointRewriteRule']);
        add_action('init', [$this, 'customRewriteTag']);
        add_action('template_redirect', [$this, 'overrideTemplate']);
    }

    /**
     * Adds a unique rewrite tag for the CERV plugin
     *
     * @return void
     */
    public function customRewriteTag()
    {
        add_rewrite_tag("%cerv_endpoint%", '([^&]+)');
    }
    
    /**
     * Adds a query var that is unique to CERV plugin
     * Note: This function is not implement but is an
     * alternative solution to add_rewrite_tag
     * add_filter( 'query_vars',  array($this, 'addQueryVars'));
     *
     * @return array
     */
    public function addQueryVars(array $queryVars): array
    {
        $queryVars[] = 'cerv_endpoint';
        return $queryVars;
    }

    /**
     * Adds a rewrite rule for the custom endpoint and flush rewrite rules
     *
     * @return void
     */
    public function customEnpointRewriteRule()
    {
        $endpointOptionValue = esc_attr(get_option('cerv_custom_endpoint_field'));
        $endpoint = ( !empty($endpointOptionValue) ) ? $endpointOptionValue : $this->defaultEndpoint;
        add_rewrite_rule("^{$endpoint}$", 'index.php?cerv_endpoint=1', 'top');
        flush_rewrite_rules();
    }

    /**
     * Overrides the template if our custom query var is loaded
     *
     * @return void
     */
    public function overrideTemplate()
    {
        $queryVar = get_query_var('cerv_endpoint');
        if ($queryVar) {
            $this->renderEndpointTemplate();
            $this->exit();
        }
    }

    /**
     * Renders the correct template based on the results of loading the resource
     *
     * @return void
     */
    public function renderEndpointTemplate()
    {
        $this->loadAssets();
        $selectedResourceOption = esc_attr(get_option('resource_select'));

        $resource = $this->loadResource($selectedResourceOption);

        if ($resource['hasErrors']) {
            $this->loadTemplate('error.php', $resource);
            return;
        }

        $templateResource = ['title' => ucfirst($selectedResourceOption), 'data' => array_slice($resource['data'], 0, 10)];
        $this->loadTemplate("{$selectedResourceOption}.php", $templateResource);
    }

    /**
     * Loads the styles and scripts for our custom enpoint page
     *
     * @return void
     */
    public function loadAssets()
    {

        $assets = AssetsService::instance();
        $assets->enqueueScripts(['cerv-resource-list']);
        $assets->enqueueStyles(['cerv-resource-style', 'cerv-modal-style']);
    }

    /**
     * Loads the resource data for our custom enpoint page
     *
     * @return void
     */
    public function loadResource(string $resource = ''): array
    {

        $resourceService = new ResourceService();
        return $resourceService->fetchResource($resource);
    }

    /**
     * Loads the template for our custom enpoint page
     *
     * @return void
     */
    public function loadTemplate(string $template, array $data)
    {

        $templateResource = $data; // $templateResource is used in the template to render things
        require_once TemplateManager::pluginTemplate($template);
    }

    /**
     * Stops all execution of code after the template has been loaded
     *
     * @return void
     */
    public function exit(string $message = "")
    {
        die(esc_html($message));
    }
}
