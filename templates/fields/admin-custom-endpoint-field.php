<?php

$endpointOptionValue = esc_attr(get_option('cerv_custom_endpoint_field'));
$endpoint = ( !empty($endpointOptionValue) ) ? $endpointOptionValue : Includes\Config::get('defaultEndpoint');

echo '<input type="text" name="cerv_custom_endpoint_field" value="' . $endpoint . '" placeholder="Customize your enpoint here">';

?>

<span style="color:green; font-weight:thin">Please refer to the rules above before saving.</span>