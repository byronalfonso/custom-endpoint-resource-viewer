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

## How it Works:

In a nutshell, the plugin registers a custom endpoint ( statically set to "`/cerv`" ), executes an HTTP request to a 3rd party API (statically set to https://jsonplaceholder.typicode.com) and displays the data (or resource as I call it) to a custom template associated with the custom endpoint

