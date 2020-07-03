<?php
namespace Includes\Managers;

use Includes\Config;

final class TemplateManager
{
	/**
	 * Gets the plugin template from the plugins/templates dir
	 * 
	 * @return $pluginTemplate - string
	 */
	public static function getPluginTemplate(String $templateName){
		$template = Config::get('pluginTemplatePath') . $templateName;

		if(file_exists($template)){
			return $template;
		}

		return -1;
	}

	/**
	 * * Gets the plugin template from the plugins/templates dir
	 * 
	 * @return $themeTemplate - string
	 */
	public static function getThemeTemplate(String $templateName){
		/*
			Implement logic later
			The plan is to give the user the ability to override the plugin template from theme directory
		*/
	}
}
