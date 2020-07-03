<?php
namespace Includes\Interfaces;

interface PluginServiceInterface {
    /**
     * Initializes and runs the logic (hooks, filters etc) of the plugin service
     *     
     */
    function initialize();
}