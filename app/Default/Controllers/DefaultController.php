<?php

namespace Default\Controllers;

use Core\BaseController;

class DefaultController extends BaseController
{
    public function index()
    {
        parent::renderView('Default', 'default', 'home');
    }

    public function notfound()
    {
        parent::renderView('Default', 'default', 'notfound');
    }
}
