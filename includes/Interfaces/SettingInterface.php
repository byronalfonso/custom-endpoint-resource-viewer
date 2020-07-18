<?php

declare(strict_types=1);

namespace Includes\Interfaces;

interface SettingInterface
{

    /**
     * Initializes the page
     *
     */
    public function initSettings();

    /**
     * Returns the options for the page
     *
     */
    public function getOptions();

    /**
     * Returns the options for the page
     *
     */
    public function getSections();

    /**
     * Returns the options for the page
     *
     */
    public function getFields();
}
