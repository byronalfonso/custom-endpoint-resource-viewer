<?php

declare(strict_types=1);

namespace Includes\Interfaces;

interface PluginServiceInterface
{

    /**
     * Initializes and runs the logic (hooks, filters etc) of the plugin service
     *
     */
    public function initialize();
}
