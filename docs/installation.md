Installation
============

Requirements
------------

You need to install a fresh copy of CakePHP 3.x. Read the [Quick Start](http://book.cakephp.org/3.0/en/quickstart.html) for more info.

You also need the [Migrations[(https://github.com/cakephp/migrations) plugin from CakePHP itself. We already required it via the CakeManagers `composer.json`.

Installing CakeManager
----------------------

We asume you already got a new project of CakePHP. You can call the plugin via composer:

    "bobmulder/cakephp-cakemanager": "dev-master"

After that we need to load our plugin in our config/bootstrap.php. We also need the Migrations-plugin from CakePHP to load our tables.

    Plugin::load('CakeManager', ['bootstrap' => true, 'routes' => true, 'autoload' => true]);
    Plugin::load('Migrations');


Adding the component
----------

After loading the plugin we have to load the base-component: `CakeManager.Manager`.

    public function initialize() {
        
        // code

        $this->loadComponent('CakeManager.Manager');
        
        // code
        
    }

### Configuring the Manager

There are multiple configurations for the manager-component.
See the [Manager Component](Components/Manager.md) for detailed documentation about the Manager-component.

Further reading
-------

You just started with the CakeManager.

Here are some suggestions related to this tutorial:
- CakePHP's [Quick Start](http://book.cakephp.org/3.0/en/quickstart.html) for 3.x.
- Read the [Manager Component](Components/Manager.md) for detailed documentation about the Manager-component.
- Read the [Request Flow](Request-Flow.md) for detailed documentation about callbacks and events via the CakeManager.
- Read the [Configurations](Configurations.md) for detailed documentation about the available configurations of the plugin.
