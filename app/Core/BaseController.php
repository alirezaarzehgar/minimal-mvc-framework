<?php

namespace Core;

use Core\Interfaces\ControllerInterface;

class BaseController implements ControllerInterface
{
    public function renderView(
        string $module,
        string $controller,
        string $view,
        array $data = []
    ) {
        require __DIR__ . "/../$module/Views/$controller/$view.php";
    }
}
