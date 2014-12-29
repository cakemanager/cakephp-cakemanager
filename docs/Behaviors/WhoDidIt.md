WhoDidIt-Behavior
==================

The WhoDidIt-Behavior can be used to know who created, and who modified a specific post. 

Loading
-------

You can load the behavior by the follwing code:

    public function initialize(array $config) {
        // code
        $this->addBehavior('CakeManager.WhoDidIt');
    }

Registering the data
--------------------

The behavior will use two fields: `created_by` and `modified_by`. Just create this fields in your database, and the behavior will add the user-id in the right field. You don't need to add this at you forms.

### Changing the columns
You can change the fields in the config of your behavior:

    public function initialize(array $config) {
        // code
        $this->addBehavior('CakeManager.WhoDidIt', [
            'created_by' => 'my_field1',
            'modified_by' => 'my_field2',
        ]);
    }

The behavior will get the users `id` from the Auth-data in the Session.

Getting the data
----------------    

The behavior will automatically get the user-data of the user who created and modified the post.

### Changing the Model
Maybe are you using another Model instead of the default Model (`CakeManager,Users`).
You can change the model in the config of your behavior:

    public function initialize(array $config) {
        // code
        $this->addBehavior('CakeManager.WhoDidIt', [
            'userModel' => 'my_custom_model',
        ]);
    }
