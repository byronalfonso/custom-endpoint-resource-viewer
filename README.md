# Custom Enpoint Resource Viewer (CERV)

Custom Enpoint Resource Viewer or CERV is a Wordpress plugin developed to generate a custom endpoint and load data from an external resource or API.

## Dependencies
- [Guzzle](https://github.com/guzzle/guzzle) - used for http request
- [guzzle-cache-middleware](https://github.com/Kevinrob/guzzle-cache-middleware) - Guzzle middleware for caching
- [doctrine/cache](https://github.com/doctrine/cache) - http caching mechanism in use

## Quick Installation:

Note: This guide requires [git](https://git-scm.com/) and [composer](https://getcomposer.org/)

* Go to your site's `wp-config/plugins` directory and clone this repo.

```
git clone https://github.com/byronalfonso/custom-endpoint-resource-viewer.git
```

* `cd` to your plugin directory and run `composer install`
* Once your plugin and its dependencies are installed, simply activate it from the wp-admin dashboard.

---

## How to use:

Once the plugin is installed, you can simply access `/cerv` on your Wordpress site e.g. `http://yourwordpresssite.com/cerv`. Once in the page, you should be able to see the list of resource. On the user table, you can click on each of the user's id, name and username and will load the details of the selected user in a modal window.

#### Features
- Loading of resource. Currently set to display `users` by default.
- Ability to modify the custom endpoint
- Custom endpoint validation
- Ability to select a resource. Currently supports, `users`, `posts`, and `photos`
- Modal window for resource (e.g. users) details.
- Error handling and custom error page in case the resource is not properly loaded.
- Error handling in the frontend, if for some reason the AJAX fails, the modal window will display an error.
- Responsive resource list table
- Http Caching
- CERV Settings page
- Easy to extend code
- Most if not all important parts were unit test (100% passing)
- PHPCS (100% Code compliance)

---

## In a nutshell:

The plugin registers a custom endpoint ( defaults to "`/cerv`" ), targets a known and existing resource (e.g. "`/users`") from a 3rd party API and executes an HTTP request there (set to https://jsonplaceholder.typicode.com), and displays the data to a custom template associated with the custom endpoint

## Under the hood:

The plugin is started by executing the run function of the main plugin class CERV.php 

```php
Includes\CERV::run();
```

This in turn initializes all the registered "plugin services" of the app. These include the following classes: 

- `Includes\Services\CustomEndpointService`
- `Includes\Services\AssetsService`
- `Includes\Admin\LinksService`
- `Includes\Admin\MenuPageService`
- `Includes\Admin\SettingsService`
 

### CustomEndpointService

The CustomEndpointService basically takes care of registering and custom endpoint as well as the query_var required for it to work. It also Takes care of loading the assets (registered & enqueued by the AssetsService), resource and template associated with the custom endpoint.

### AssetsService

The job of the AssetsService is to register all the required assets (scripts and styles) and localize them. It also takes care of enqueueing the registered assets upon execution of its public functions `enqueueScripts` and `enqueueStyles`.

### LinksService

The LinksService's job is to simply add links on the plugin description, (beside the activate and deactivate link) inside the plugins page of the Wordpress admin dashboard.

### MenuPageService

Handles the creation of menu pages and links for the admin side. It does this by creating a "Page" class that implements the `Includes\Interfaces\PageInterface` interface and registering it in itself (the MenuPageService class).

### SettingsService

Takes care of adding contents, settings, sections and fields for a menu page. It does this by creating a "Setting" class that implements the `Includes\Interfaces\SettingInterface`.


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


With regards to Http caching, I've initially I've thought about creating my own caching mechanism using the [Wordpress Object cache](https://codex.wordpress.org/Class_Reference/WP_Object_Cache) or with PHP session. However, since I'm already using Guzzle, I realized that there should be an already existing solution and I wasn't wrong. I found [guzzle-cache-middleware](https://github.com/Kevinrob/guzzle-cache-middleware) which has a built-in support for different types of caching mechanism including Wordpress Object cache. Pretty neat right? However, after testing and debugging, I've ended up choosing the [Doctrine Cache](https://github.com/doctrine/cache) instead of the Wordpress Object cache due to the loading speed. While testing, I found Doctrine cache to be significantly faster compare to Wordpress Object cache.

---

### Unit Testing:

After reading a couple of resources and this [WP stack exchange article](https://wordpress.stackexchange.com/questions/164121/testing-hooks-callback/164138#164138), I've decided to use [PHPunit](https://github.com/sebastianbergmann/phpunit) along with [Brain Monkey](https://github.com/Brain-WP/BrainMonkey). After learning more about the experts opinion on "unit" testing and about Brain Monkey, it just makes so much sense to use it (Brain Monkey) to "unit" test my plugin (and just for all general theme and plugin development). I'll be honest though, learning Brain Monkey and Mockery (one of its dependencies) has a steep learning curb (IMHO), and takes awhile to get used to but you know what? It's well worth it :)

#### Code coverage:
- To my **rough estimate**, the unit testing covers around 40-50% of the code base and is currently targetting the most important parts of the code which is the main plugin class and the plugin services.
