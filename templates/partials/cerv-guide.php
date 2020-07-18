<style>
    .cerv-guide{
        margin-top: 25px;
    }


    .cerv-guide .cerv-guide-section{
        background: #ddd;
        padding: .5em 1em;
        width:97%;
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
        <p>Simply go to <a href="<?php echo get_site_url() ?>/cerv"><?php echo get_site_url() ?>/cerv</a> and you'll be able to access and view the list of resource (users only ATM)</p>
    </div>

    <div class="cerv-guide-section">
        <h2>Notes:</h2>
        <ul>
            <li>Current 3rd party API in use - The https://jsonplaceholder.typicode.com</li>
            <li>The resource being fetched from the 3rd party API is `/users` e.g. https://jsonplaceholder.typicode.com/users</li>
            <li>Customization of custom endpoint is <span style="color:green">currently disabled</span></li>
            <li>At the moment, <span style="color:green">`/users` is the only resource available</span></li>            
        </ul>

        <h3 style="color:maroon">More to come in the near future :)</h3>
    </div>
    <div class="rule"></div>
</div>
