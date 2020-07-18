<?php

declare(strict_types=1);

namespace Includes\Settings;

use Includes\Config;
use Includes\Managers\TemplateManager;
use Includes\Interfaces\SettingInterface;

class SettingsPage implements SettingInterface
{
    private $options = [];
    private $sections = [];
    private $fields = [];

    public function initSettings()
    {

        $this->setOptions();
        $this->setSections();
        $this->setFields();
    }

    public function getOptions()
    {

        return $this->options;
    }

    public function getSections()
    {

        return $this->sections;
    }

    public function getFields()
    {

        return $this->fields;
    }

    private function setOptions()
    {

        $this->options = [
            [
                'option_group' => 'cerv_settings_group',
                'option_name' => 'resource_select',
                'callback' => [ $this, 'validateResourceSelect'],
            ],
        ];
    }

    public function setSections()
    {

        $this->sections = [
            [
                'id' => 'cerv_guide_section',
                'title' => '',
                'callback' => [ $this, 'resourceGuideSectionCallback' ],
                'page' => 'cerv_settings',
            ],
            [
                'id' => 'cerv_settings_section',
                'title' => 'Resource Settings',
                'callback' => [ $this, 'resourceSettingsSectionCallback' ],
                'page' => 'cerv_settings',
            ],
        ];
    }

    public function setFields()
    {

        $this->fields = [
            [
                'id' => 'resource_select',
                'title' => '<label for="resource">Select a resource:</label>',
                'callback' => [ $this, 'resourceSelectOptions' ],
                'page' => 'cerv_settings',
                'section' => 'cerv_settings_section',
                'args' => [
                    'label_for' => 'resource_select',
                ],
            ],
        ];
    }

    
    public function checkboxSanitize($input)
    {
        $output = [];
        $output['cerv_settings_field'] = isset($input['cerv_settings_field']) ? true : false;
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

    public function resourceSelectOptions($args)
    {
        $optionValue = esc_attr(get_option('resource_select'));
        require_once TemplateManager::pluginTemplate('fields/admin-resource-select.php');
    }

    
    public function validateResourceSelect($input)
    {

        $field = 'resource_select';
        $oldValue = get_option($field);
        $newValue = $input;
        $nonceActionKey = Config::get('settingsNonceKey');
        $isValidNonce = ( isset($_POST['cerv_settings_form_nonce']) && wp_verify_nonce($_POST['cerv_settings_form_nonce'], $nonceActionKey) ) ? true : false;

        // Validate nonce
        if (!$isValidNonce) {
            $input = $oldValue;
            add_settings_error('cerv_settings_group', 'invalid_settings_nonce_key', __('Illegal operation detected. Please use a valid nonce key.', 'wpse'), 'error');
        }

        // Validate input
        if ($newValue !== 'users') {
            $input = $oldValue;
            add_settings_error('cerv_settings_group', 'invalid_resource_key', __('Invalid resource', 'wpse'), 'error');
        }

        return $input;
    }
}
