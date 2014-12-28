IsAuthorized-Component
======================

The IsAuthorized-Component allows you to to automatically check the authorization for editing and deleting posts.
The component is default loaded by the CakeManager, or can be loaded with:

```php
$this->loadComponent('CakeManager.IsAuthorized', []);
```

Configuring Component
---------------------
There are some configurations you can set. This part will explain each one.

### Model
The components uses the default model (`Controller::name`), but you can set a custom model (string).

```php
$this->IsAuthorized->config('model', 'yourModel');
```

### Method
The Component uses the default method on your selected model. This method is called `authorize`. Change the method with the folliwing code:

```php
$this->IsAuthorized->config('method', 'yourMethod');
```

Read the IsAuthorizedBehavior-section for how to customize your `authorize`-method.

### Actions
The Component checks the default actions: edit and delete. If you want to authorize custom actions use:

```php
$this->IsAuthorized->config('actions', ['action1', 'action2']);
```

### Param
Default you will use the first parameter (`$this->request->params['pass'][0]`) as id for your type, but there are situations you need another param (like: `$this->request->params['pass'][1]`). Use the following code to customize the parameter:

```php
$this->IsAuthorized->config('param', 1);
```

Activating the authorization
----------------------------

Ofcourse you want to activate the authorization. For that, you need to customize the `Controller:isAuthorized()`-method.
`
```php
public function isAuthorized($user) {

    if ($this->IsAuthorized->behaviorIsset()) {
        return $this->IsAuthorized->authorize();
    }

    // your further autorization
}
```

First we check if the behavior is set (this is required, else the component will not check).
If it's set we can authorize.

Further Reading
---------------
The component is set, now we want to activate the check by adding a behavior to specific models. Read the IsAuthorizedBehavior for more!
