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
    private $customEndpointFieldError;

    public function initSettings()
    {        
        $this->customEndpointFieldError = 'Invalid custom endpoint value. Please refer to the rules below.';
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

        if (!$this->validCustomEndpoint($oldValue, $newValue)) {
            $this->error('invalid_custom_endpoint_key', $this->customEndpointFieldError);
            return $oldValue;
        }

        return trim($input,"/-");
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

    private function validCustomEndpoint($oldEndpoint, $newEndpoint){

        /*
            Rules:
            - Must be a string
            - Must be at least 4 chars long
            - Must not exceed 15 chars
            - Can have numbers but can't start with a number
            - Must not be an existing end point (applies to all existing endpoints including the Wordpress default)
            - Can have dashes (-) but can't start with a dash.
            - More than one successive dashes are not allowed e.g. --, --- and so on
            - Can have slash (/) but can't start with a slash.
            - More than one successive slashes are not allowed e.g. //, /// and so on
            - Dashes and slashes at the end of the enpoint e.g. "enpoint-" will be removed resulting to just "endpoint"
        */
        
        if( !is_string($newEndpoint) ){
            $this->customEndpointFieldError = "Invalid custom endpoint value. Must be a valid string.";
            return false;
        }

        if( strlen($newEndpoint) < 4 || strlen($newEndpoint) > 50 ){
            $this->customEndpointFieldError = "Invalid custom endpoint value. Must be at least 4 characters long but not exceed 50.";
            return false;
        }

        if ( !preg_match("#^([A-Za-z]([A-Za-z0-9][-]?[\/]?)*)$#i", $newEndpoint) ){
            return false;
        }

        $rules = array_keys( get_option( 'rewrite_rules' ) );
        if( ($newEndpoint !== $oldEndpoint) && in_array("^{$newEndpoint}$", $rules) ){
            $this->customEndpointFieldError = "Invalid custom endpoint value. Value already exists.";
            return false;
        }

        return true;
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
