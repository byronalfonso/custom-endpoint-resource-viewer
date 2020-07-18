<?php

declare(strict_types=1);

namespace Includes\Interfaces;

interface SettingInterface
{

    /**
     * Initializes the settings
     *
     */
    public function initSettings();

    /**
     * Returns the options for the settings
     *
     */
    public function options();

    /**
     * Returns the options for the settings
     *
     */
    public function sections();

    /**
     * Returns the options for the settings
     *
     */
    public function fields();
}
