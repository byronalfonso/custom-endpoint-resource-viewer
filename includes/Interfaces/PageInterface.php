<?php

declare(strict_types=1);

namespace Includes\Interfaces;

interface PageInterface
{

    /**
     * Initializes the page
     *
     */
    public function initPage();

    /**
     * Returns the options for the page
     *
     */
    public function options();
}
