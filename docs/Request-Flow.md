Request Flow
============

In this chapter we will give explanation about a default and - by the CakeManager extended - request-flow.

This should be a normal request-flow by CakePHP:

Controller              | Component             | Events
------------            | -------------         | ------------
initialize              | []                    | []  
[]                      | beforeFilter          | [] 
beforeFilter            | []                    | []  
[]                      | startup               | [] 
= action logic =        | []                    | []  
[]                      | beforeRender          | [] 
beforeRender            | []                    | []  
[]                      | shutdown              | [] 
= action render =       | []                    | []              

* Note: The column 'Component' means all components

You can see that the common-used callbacks for the component like `beforeFilter` and `beforeRender` are surrounded by component-callbacks like `beforeFilter`, `startup`, `beforeRender` and `shutdown`.

This gave us a very clean way for our events:

Controller              | Component             | Events
------------            | -------------         | ------------
initialize              | []                    | []
[]                      | beforeFilter          | []
[]                      | []                    | Component.Manager.beforeFilter
[]                      | []                    | Component.Manager.beforeFilter.prefix
beforeFilter            | []                    | []  
[]                      | startup               | []
[]                      | []                    | Component.Manager.startup
[]                      | []                    | Component.Manager.startup.prefix
= action logic =        | []                    | []  
[]                      | beforeRender          | [] 
[]                      | []                    | Component.Manager.beforeRender
[]                      | []                    | Component.Manager.beforeRender.prefix
beforeRender            | []                    | []  
[]                      | shutdown              | []
[]                      | []                    | Component.Manager.shutdown
[]                      | []                    | Component.Manager.shutdown.prefix
= action render =       | []                    | []              

* Note: The column 'Component' means the ManagerComponent by CM; Events named after the component-callback are registered at the end of the component-event. Note that events may be called before your own components.

This information can be usefull if you want to fire your logic in an event before or after a specific callback of the controller (for use of the user).