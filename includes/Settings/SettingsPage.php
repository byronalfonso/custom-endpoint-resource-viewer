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
        $this->initOptions();
        $this->initSections();
        $this->initFields();
    }

    public function options(): array
    {

        return $this->options;
    }

    public function sections(): array
    {

        return $this->sections;
    }

    public function fields(): array
    {

        return $this->fields;
    }

    private function initOptions()
    {

        $this->options = [
            [
                'option_group' => 'cerv_settings_group',
                'option_name' => 'cerv_custom_endpoint_field',
                'callback' => [ $this, 'validateCustomEnpointField'],
            ],
            [
                'option_group' => 'cerv_settings_group',
                'option_name' => 'resource_select',
                'callback' => [ $this, 'validateResourceSelect'],
            ],
        ];
    }

    public function initSections()
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

    public function initFields()
    {

        $this->fields = [
            [
                'id' => 'cerv_custom_endpoint_field',
                'title' => 'Customize the endpoint',
                'callback' => [ $this, 'cervCustomEndpointField' ],
                'page' => 'cerv_settings',
                'section' => 'cerv_settings_section',
                'args' => [
                    'label_for' => 'cerv_custom_endpoint_field',
                ],
            ],
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

    public function resourceGuideSectionCallback()
    {
        require_once TemplateManager::pluginTemplate('partials/cerv-guide.php');
    }

    public function resourceSettingsSectionCallback()
    {
        echo '<h4>This section is where you can manage and configure your resource.</h4>';
    }

    public function cervCustomEndpointField(array $args)
    {
        require_once TemplateManager::pluginTemplate('fields/admin-custom-endpoint-field.php');
    }

    public function resourceSelectOptions(array $args)
    {
        $optionValue = esc_attr(get_option('resource_select'));
        require_once TemplateManager::pluginTemplate('fields/admin-resource-select.php');
    }

    public function validateCustomEnpointField(string $input): string
    {

        $field = 'cerv_custom_endpoint_field';
        $oldValue = esc_attr(get_option($field));        
        $newValue = sanitize_text_field($input);

        // Validate nonce
        if (!$this->validNonce()) {
            $this->invalidNonceError('custom endpoint');
            return $oldValue;
        }

        if (!$this->validCustomEndpoint($newValue)) {
            $this->error('invalid_custom_endpoint_key', 'Invalid custom endpoint value. Please refer to the rules below.');
        }

        return $input;
    }

    
    public function validateResourceSelect(string $input): string
    {

        $field = 'resource_select';
        $oldValue = get_option($field);
        $newValue = sanitize_text_field($input);

        // Validate nonce
        if (!$this->validNonce()) {
            $this->invalidNonceError('resource');
            return $oldValue;
        }

        // Validate input. Note: this currently it only accepts one value
        if ($newValue !== 'users') {
            $this->error('invalid_resource_key', 'Invalid resource field value.');
            return $oldValue;
        }

        return $input;
    }

    private function validNonce(){
        $nonceActionKey = Config::get('settingsNonceKey');
        return ( isset($_POST['cerv_settings_form_nonce']) &&
            wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['cerv_settings_form_nonce'])), $nonceActionKey) ) ? true : false;
    }

    private function validCustomEndpoint($endpoint){
        return false; // return false for now. add logic later
    }

    private function invalidNonceError(string $field = ""){
        $message = 'Invalid nonce key detected';

        if($field){
            $message .= " while saving the " . $field . " field.";
        }

        $this->error('invalid_settings_nonce_key', $message);
    }

    private function error(string $key, string $message){
        add_settings_error(
            'cerv_settings_group',
            'invalid_settings_nonce_key',
            __($message, 'custom-endpoint-resource-viewer'),
            'error'
        );
    }
}
