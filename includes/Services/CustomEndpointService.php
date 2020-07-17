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

    public function customEnpointRewriteRule()
    {
        add_rewrite_rule("^{$this->defaultEndpoint}$", 'index.php?cerv_endpoint=1', 'top');
        flush_rewrite_rules();
    }

    public function overrideTemplate()
    {
        $queryVar = get_query_var('cerv_endpoint');
        if ($queryVar) {
            $this->renderEndpointTemplate();
            $this->exit();
        }
    }

    public function renderEndpointTemplate()
    {
        $this->loadAssets();        
        $resource = $this->loadResource('/users');

        if ($resource['hasErrors']) {
            $this->loadTemplate('error.php', $resource);
            return;
        }

        $templateResource = ['title' => 'Users', 'data' => $resource['data']];
        $this->loadTemplate('custom.php', $templateResource, $resource);
    }

    public function loadAssets(){
        $assets = AssetsService::instance();
        $assets->enqueueScripts(['cerv-resource-list']);
        $assets->enqueueStyles(['cerv-resource-style', 'cerv-modal-style']);
    }

    public function loadResource(string $resource = ''): array{
        $resourceService = new ResourceService();
        return $resourceService->fetchResource($resource);
    }

    public function loadTemplate(string $template, $data){
        $templateResource = $data; // $templateResource is used in the template to render things
        require_once TemplateManager::pluginTemplate($template);
    }

    public function exit(string $message="")
    {
        die($message);
    }
}
