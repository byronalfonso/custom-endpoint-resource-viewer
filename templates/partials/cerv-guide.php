<?php
$endpointOptionValue = esc_attr(get_option('cerv_custom_endpoint_field'));
$endpoint = ( !empty($endpointOptionValue) ) ? $endpointOptionValue : Includes\Config::get('defaultEndpoint');
?>

<style>
    .cerv-guide{
        margin-top: 25px;
    }


    .cerv-guide .cerv-guide-section{
        background: #ddd;
        padding: .5em .8em;
        width:97%;
    }

    .cerv-guide .rules-section ul{
        list-style-type: square;
        padding-left: 1.75em;
    }

    .cerv-guide .rule{
        height: 1px;
        width: 100%;
        background: #777;
        margin-top: 35px;
        margin-bottom: 35px;
    }
</style>

<div class="cerv-guide">
    
    <div class="cerv-guide-section">
        <h2>What is CERV?</h2>
        <p>Custom Enpoint Resource Viewer or CERV is a Wordpress plugin developed to generate a custom endpoint and load data from an external resource or API.</p>
    </div>

    <div class="cerv-guide-section">
        <h2>How it works?</h2>
        <p>The plugin registers a custom endpoint ( currently set to "/cerv" ), targets a known and existing resource (e.g. "/users") from a 3rd party API and executes an HTTP request there (set to https://jsonplaceholder.typicode.com), and displays the data to a custom template associated with the custom endpoint</p>
    </div>
    
    <div class="cerv-guide-section">
        <h2>How to use?</h2>
        <ol>
            <li>Add your custom endpoint</li>
            <li>Choose a resource</li>
            <li>And simply go to this link <a href="<?php echo get_site_url() ?>/<?php echo $endpoint;?>"><?php echo get_site_url() ?>/<?php echo $endpoint;?></a> to view the resource page.</li>
        </ol>
    </div>

    <div class="cerv-guide-section rules-section">
        <h2>Custom Endpoint Rules:</span></h2>
        <ul>
            <li>Must be a string</li>
            <li>Must be at least 4 chars long</li>
            <li>Must not exceed 50 chars</li>
            <li>Can have numbers but can't start with a number</li>
            <li>Must not be an existing end point (applies to all existing endpoints including the Wordpress default)</li>
            <li>Can have dashes (-) but can't start with a dash.</li>
            <li>More than one successive dashes are not allowed e.g. --, --- and so on.</li>
            <li>Can have slash (/) but can't start with a slash.</li>
            <li>More than one successive slashes are not allowed e.g. //, /// and so on.</li>
        </ul>
    </div>

    <div class="cerv-guide-section">
        <h2>Notes:</h2>
        <ul>
            <li>Current 3rd party API in use - The https://jsonplaceholder.typicode.com</li>
            <li>The resource being fetched from the 3rd party API is `/users` e.g. https://jsonplaceholder.typicode.com/users</li>
        </ul>
    </div>
</div>
