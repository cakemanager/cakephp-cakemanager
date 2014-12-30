Quick Start
===========

The best way to experience and learn CakeManager is to sit down and build something. To start off we’ll build a simple bookmarking application, just like you did as first tutorial at [CakePHP](http://book.cakephp.org/3.0/en/quickstart.html).

Beginner Tutorial
===================
In this tutorial we will add our CakeManager. So, that means we will have our login-system, and will be able to use extra plugins to make our work easier

Getting the CakeManager
-----------------------
We asume you already got a new project of CakePHP. You can call the plugin via composer:

    "bobmulder/cakephp-cakemanager": "dev-master"

After that we need to load our plugin in our `config/bootstrap.php`:

    Plugin::load('CakeManager', ['bootstrap' => true, 'routes' => true, 'autoload' => true]);

Creating the Schemas
--------------------

After loading our plugin we need the Schema's of CakeManager.

> Note: Schema's are not supported yet.

