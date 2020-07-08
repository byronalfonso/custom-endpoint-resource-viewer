<?php

declare(strict_types=1);

namespace Includes\Managers;

use Includes\Config;

final class TemplateManager
{
    /**
     * Gets the plugin template from the plugins/templates dir
     *
     * @return $pluginTemplate - string
     */
    public static function pluginTemplate(string $templateName): string
    {
        $template = Config::get('pluginTemplatePath') . $templateName;

        if (!file_exists($template)) {
            throw new Exception("The template: {$template} does not exists.", 1);
        }

        return $template;
    }

    /**
     * * Gets the plugin template from the plugins/templates dir
     *
     * @return string $themeTemplate
     */
    public static function themeTemplate(string $templateName): string
    {
        $template = Config::get('themeTemplatePath') . $templateName;

        if (!file_exists($template)) {
            throw new Exception("The template: {$template} does not exists.", 1);
        }

        return $template;
    }
}
