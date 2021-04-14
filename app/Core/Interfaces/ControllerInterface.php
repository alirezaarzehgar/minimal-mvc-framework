<?php

namespace Core\Interfaces;

interface ControllerInterface
{
    public function renderView(
        string $module,
        string $controller,
        string $view,
        array $data = []
    );
}
