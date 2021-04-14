<?php

namespace Core;

class Routing
{
    public $routes = [
        [
            'route' => '',
            'module' => 'Default',
            'controller' => 'DefaultController',
            'action' => 'index',
        ],
        [
            'route' => 'test',
            'module' => 'new',
            'controller' => 'Ali',
            'action' => 'index'
        ]
    ];

    public function __construct()
    {
        return $this->routes;
    }
}
