# Custom Enpoint Resource Viewer (CERV)

Custom Enpoint Resource Viewer or CERV is a Wordpress plugin developed to generate a custom endpoint and load data from an external resource or API.

## Quick Installation:

Note: This guide requires [git](https://git-scm.com/) and [composer](https://getcomposer.org/)

* Go to your site's `wp-config/plugins` directory and clone this repo.

```
git clone https://github.com/byronalfonso/custom-endpoint-resource-viewer.git
```

* `cd` to your plugin directory and run `composer install`
* Once your plugin and its dependencies are installed, simply activate it from the wp-admin dashboard.

---

## In a nutshell:

The plugin registers a custom endpoint ( defaults to "`/cerv`" ), targets a known and existing resource (e.g. "`/users`") from a 3rd party API and executes an HTTP request there (set to https://jsonplaceholder.typicode.com), and displays the data to a custom template associated with the custom endpoint

## Under the hood:

The plugin is started by executing the run function from the main plugin class CERV.php 

```php
Includes\CERV::run();
```

This in turn initializes all the registered "plugin services" of the app. These include the following classes `Includes\Services\CustomEndpointService` and `Includes\Services\AssetsService`. 

### CustomEndpointService

The CustomEndpointService basically takes care of registering and custom endpoint as well as the query_var required for it to work. It also Takes care of loading the assets (registered & enqueued by the AssetsService), resource and template associated with the custom endpoint.

### AssetsService

The job of the AssetsService is to register all the required assets (scripts and styles) and localize them. It also takes care of enqueueing the registered assets upon execution of its public functions `enqueueScripts` and `enqueueStyles`.
