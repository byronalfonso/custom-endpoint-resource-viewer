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


## Development:

### System Environment:
The plugin was developed and tested on the following system environment

- php 7.4
- mysql 5.7
- Wordpress 5.4.2

---

### Http Request and Caching:

Note: depends on the following packages.

```js
"require": {
    "guzzlehttp/guzzle": "^7.1@dev",
    "kevinrob/guzzle-cache-middleware": "dev-master",
    "doctrine/cache": "^1.11@dev"
}
```

I've opted with [Guzzle](http://docs.guzzlephp.org/en/stable/), Simply because it is reliable (I've used it before), easy to setup and (IMHO) trusted by many other developers and frameworks. Also, I feel like I'm going to recreate the wheel if I create my own class that encapsulates a CURL or any built-in mechanism that allows for an http request.


With regards to Http caching, I've initially I've thought about creating my own caching mechanism using the [Wordpress Object cache](https://codex.wordpress.org/Class_Reference/WP_Object_Cache) or with PHP session. However, since I'm already using Guzzle, I realized that there should be an already existing solution and I wasn't wrong. I found [guzzle-cache-middleware](kevinrob/guzzle-cache-middleware) which has a built-in support for different types of caching mechanism including Wordpress Object cache. Pretty neat right? However, after testing and debugging, I've ended up choosing the [Doctrine Cache](https://github.com/doctrine/cache) instead of the Wordpress Object cache due to the loading speed. While testing, I found Doctrine cache to be significantly faster compare to Wordpress Object cache.

---

### Unit Testing:

After reading a couple of resources and this [WP stack exchange article](https://wordpress.stackexchange.com/questions/164121/testing-hooks-callback/164138#164138), I've decided to use [PHPunit](https://github.com/sebastianbergmann/phpunit) along with [Brain Monkey](https://github.com/Brain-WP/BrainMonkey). After learning more about the experts opinion on "unit" testing and about Brain Monkey, it just makes so much sense to use it (Brain Monkey) to "unit" test my plugin (and just for all general theme and plugin development). I'll be honest though, learning Brain Monkey and Mockery (one of its dependencies) has a steep learning curb (IMHO), and takes awhile to get used to but you know what? It's well worth it :)

