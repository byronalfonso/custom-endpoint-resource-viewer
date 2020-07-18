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
    public function getOptions();

    /**
     * Returns the options for the settings
     *
     */
    public function getSections();

    /**
     * Returns the options for the settings
     *
     */
    public function getFields();
}
