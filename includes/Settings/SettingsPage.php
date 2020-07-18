<?php

declare(strict_types=1);

namespace Includes\Settings;

use Includes\Config;
use Includes\Managers\TemplateManager;

class SettingsPage
{
    private $options = [];
    private $sections = [];
    private $fields = [];

    public function getOptions(){
        return $this->options;
    }

    public function getSections(){
        return $this->sections;
    }

    public function getFields(){
        return $this->fields;
    }

    public function initSettings(){
        $this->setOptions();
        $this->setSections();
        $this->setFields();
    }

    private function setOptions(){
        $this->options = array(
			array(
				'option_group' => 'cerv_settings_group',
				'option_name' => 'resource_select'
			)
        );
    }

    public function setSections(){
        $this->sections = array(
            array(
                'id' => 'cerv_guide_section',
                'title' => '',
                'callback' => array( $this, 'resourceGuideSectionCallback' ),
                'page' => 'cerv_settings'
            ),
			array(
                'id' => 'cerv_settings_section',
                'title' => 'Resource Settings',
                'callback' => array( $this, 'resourceSettingsSectionCallback' ),
                'page' => 'cerv_settings'
            )
        );
    }

    public function setFields(){
        $this->fields = array(
			array(
				'id' => 'resource_select',
				'title' => '<label for="resource">Select a resource:</label>',
				'callback' => array( $this, 'resourceSelectOptions' ),
				'page' => 'cerv_settings',
				'section' => 'cerv_settings_section',
				'args' => array(
                    'label_for' => 'resource_select'
                )
			)
        );
    }
    
    public function checkboxSanitize( $input )
	{
		$output = array();
        $output['cerv_settings_field'] = isset( $input['cerv_settings_field'] ) ? true : false;
		return $output;
	}

	public function resourceGuideSectionCallback()
	{
        require_once TemplateManager::pluginTemplate('partials/cerv-guide.php');
	}

	public function resourceSettingsSectionCallback()
	{
        echo '<h4>This section is where you can manage and configure your resource.</h4>';
	}

	public function resourceSelectOptions( $args )
	{
        $optionValue = esc_attr( get_option( 'resource_select' ) );
        require_once TemplateManager::pluginTemplate('fields/admin-resource-select.php');
	}
}
