# minimal mvc framework

i created a MVC framework for PHP.

this project is sample and my purpose for creating this repository is excercies.

you can use my framework for develop minimal web apps quickly.
this project has a artisan tools for manage project from command line.

you can create controller, action, model just with write one line of code on cli.

## usage

this is my folder structure :

```
app
├── Core
│   ├── App.php
│   ├── BaseController.php
│   ├── Console
│   │   ├── App.php
│   │   ├── Color.php
│   │   ├── Commands.php
│   │   └── DefaultCode.php
│   ├── Interfaces
│   │   └── ControllerInterface.php
│   └── Routing.php
└── Default
    ├── Controllers
    │   └── DefaultController.php
    └── Views
        └── default
            ├── home.php
            └── notfound.php
```

#### app

    this is root directory for this framework.

#### Core

    in this folder you can route your app.

##### App.php

    this file is main file for framework.
    if you wanna start project, you can `new` this class to your index file.
    this file parsing routes and execute controllers.
    actually this file is heart of framework.

##### Routing.php

    this file is most important file in framework.
    you should create and change your app routes from this file.


    public $routes = [
        [
            'route' => '',
            'module' => 'Default',
            'controller' => 'DefaultController',
            'action' => 'index',
        ]
    ];


    you should add new routes to this variable.

##### Consolse

    this file contains all libraries that used in artisan and command line interface.
    you don't need to change this file for your project.

##### Interfaces

    this folder contains all interfaces that you want to implement it.

#### Default

    this directory is just a test!

## how this works!

    in this framework you can create a module.
    this module can be a complete app.
    you can add another modules for create a new feature or new app component ...
    however totally up to you.

    when you created a module you can create Model, View and Controller.
    i suggest you this file structure :

```

Default
├── Configs
│   └── Database.php
├── Controllers
│   └── DefaultController.php
├── Models
│   ├── Admin.php
│   └── User.php
├── Utils
└── Views
    └── default
        ├── home.php
        └── notfound.php
```

`Configs` for database info, `Controllers` for create connection between View and Model, `Models` for create your models
and `Views` for your views.

## Create an app

clone our repo.

`git clone https://github.com/alirezaarzehgar/minimal-mvc-framework.git`

`mv minimal-mvc-framework myProj`

`cd myProj`

initializing composer for autoloading classes.

`composer dump-autoload -o`

now you can use it.
let's run application.

`./artisan serve`

this is the true output:

```

[Wed Apr 14 08:17:32 2021] PHP 8.0.3 Development Server (http://localhost:8080) started

```

you can test localhost:8080 on your browser.

let's create new module and test it.

Create new module

`./artisan make:module myApp`

Create new controller

`./artisan make:controller myApp Handler`

Create new view

`./artisan make:view myApp def index`

Create new action

`./artisan make:action myApp Handler index def index`

Create new route

`./artisan make:route test myApp Handler index`

Then you can dump autoload.

`composer dump-autoload -o`

`./artisan serve`

Then if you enter localhost:8080/test you will see Index.
You can change this view from app/myApp/Views/index.php
