<?php

namespace Core;

use Default\Controllers\DefaultController;

class App
{
    private $controller;
    private $action;

    public function parseUrl()
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        $request = explode('/', $request);
        return $request;
    }

    public function __construct()
    {
        $url = $this->parseUrl();
        $routing = new Routing;

        // default
        $this->controller = new DefaultController;
        $this->action = 'notfound';

        if ($routing->routes) {
            foreach ($routing->routes as $route) {
                $controllerPlusAction = $url[0] . (is_null($url[1] ?? null) ? '' : '/' . $url[1]);

                if ($route['route'] == $controllerPlusAction) {
                    $controllerName = "\\" . $route['module'] . "\Controllers\\" . $route['controller'];

                    $this->controller = new $controllerName;
                    $this->action = $route['action'];
                }
            }
        }

        call_user_func([$this->controller, $this->action]);
    }
}
