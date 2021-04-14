<?php

namespace Core\Console;

class Commands
{
    public static $commands = [
        'serve',
        'make' => [
            'controller',
            'model',
            'view',
            'action',
            'module',
            'route',
            'make',
        ],
    ];

    private $MODULES_PATH = __DIR__ . '/../../';
    private $CONTROLLERS_PATH = __DIR__ . 'Controllers/';
    private $VIEWS_PATH = __DIR__ . '/../../Views/';
    private $MODELS_PATH = __DIR__ . '/../../Models/';

    private $defaultCode;

    public function __construct()
    {
        $this->defaultCode = new DefaultCode;
    }

    private function error($message)
    {
        $space = null;

        for ($i = 0; $i < strlen($message); $i++)
            $space .= " ";

        $error_banner =
            "\n" .
            Color::$BACK_ERROR . "  $space  " . Color::$END . "\n" .
            Color::$BACK_ERROR . "  $message  " . Color::$END . "\n" .
            Color::$BACK_ERROR . "  $space  " . Color::$END . "\n" .
            "\n";

        die($error_banner);
    }

    public static function serve(array $args)
    {
        $host = $args[0] ?? 'localhost';
        $port = $args[1] ?? '8080';
        $rootDir = $args[2] ?? 'public';

        `php -S $host:$port -t $rootDir`;
    }

    private function makeView(array $args)
    {
        if (!isset($args[0]))
            $this->error("Not enough arguments (missing: \"module name\").");

        if (!isset($args[1]))
            $this->error("Not enough arguments (missing: \"view name\").");

        if (!isset($args[2]))
            $this->error("Not enough arguments (missing: \"controller name\").");



        $module = $args[0];
        $controller = $args[1];
        $view = $args[2];

        if (!file_exists($this->MODULES_PATH . $module))
            $this->error("module $module dose not exits");

        if (file_exists($this->CONTROLLERS_PATH . 'Views/' . $controller))
            $this->error("controller $controller already exits");

        if (file_exists($this->CONTROLLERS_PATH . $view))
            $this->error("view $view already exits");

        $viewsFolder = $this->MODULES_PATH . '/' .  $module . '/Views/';
        $controllersFolder = $this->MODULES_PATH . '/' .  $module . '/Views/' . $controller;

        if (!file_exists($viewsFolder))
            mkdir($viewsFolder);

        if (!file_exists($controllersFolder))
            mkdir($controllersFolder);

        $this->defaultCode->createView($controllersFolder, $view);
    }

    private function makeModel(array $args)
    {
        if (!isset($args[0]))
            $this->error("Not enough arguments (missing: \"module name\").");

        if (!isset($args[1]))
            $this->error("Not enough arguments (missing: \"model name\").");

        $module = $args[0];
        $model = $args[1];

        if (!file_exists($this->MODULES_PATH . $module))
            $this->error("module $module dose not exits");

        if (file_exists($this->CONTROLLERS_PATH . $model))
            $this->error("model $model already exits");

        $modelsFolder = $this->MODULES_PATH . '/' .  $module . '/Models/';

        if (!file_exists($modelsFolder))
            mkdir($modelsFolder);

        $this->defaultCode->createModel($modelsFolder, $module, $model);
        $this->defaultCode->addAutoload($module);
    }

    private function makeController(array $args)
    {
        if (!isset($args[0]))
            $this->error("Not enough arguments (missing: \"module name\").");

        if (!isset($args[1]))
            $this->error("Not enough arguments (missing: \"controller name\").");


        $module = $args[0];
        $controller = $args[1];

        if (!file_exists($this->MODULES_PATH . $module))
            $this->error("module $module dose not exits");

        if (file_exists($this->CONTROLLERS_PATH . $controller))
            $this->error("controller $controller already exits");

        $controllersFolder = $this->MODULES_PATH . '/' .  $module . '/Controllers/';

        if (!file_exists($controllersFolder))
            mkdir($controllersFolder);

        $this->defaultCode->createController($controllersFolder, $module, $controller);
        $this->defaultCode->addAutoload($module);
    }

    private function makeAction(array $args)
    {
        if (!isset($args[0]))
            $this->error("Not enough arguments (missing: \"module name\").");

        if (!isset($args[1]))
            $this->error("Not enough arguments (missing: \"controller name\").");

        if (!isset($args[2]))
            $this->error("Not enough arguments (missing: \"action name\").");

        if (!isset($args[3]))
            $this->error("Not enough arguments (missing: \"view controller name\").");

        if (!isset($args[4]))
            $this->error("Not enough arguments (missing: \"view name\").");

        $module = $args[0];
        $controller = $args[1];
        $action = $args[2];
        $viewController = $args[3];
        $view = $args[4];

        if (!file_exists($this->MODULES_PATH . $module))
            $this->error("module $module dose not exits");

        if (!file_exists(__DIR__ . "/../../$module/Controllers/$controller.php"))
            $this->error("controller $controller dose not exits");

        if (!file_exists(__DIR__ . "/../../$module/Views/$viewController/$view.php"))
            $this->error("view $view dose not exits");

        $controllersFolder = $this->MODULES_PATH . '/' .  $module . '/Controllers/';

        if (!file_exists($controllersFolder))
            mkdir($controllersFolder);

        $res = $this->defaultCode->createAction(
            __DIR__ . "/../../$module/Controllers/$controller.php",
            $action,
            $module,
            $viewController,
            $view
        );

        if ($res === false)
            $this->error("action $action aleady exists.");
    }

    private function makeModule(array $args)
    {
        if (!isset($args[0]))
            $this->error("Not enough arguments (missing: \"module name\").");

        $moduleName = $args[0];
        $modulePath = $this->MODULES_PATH . $moduleName;

        if (file_exists($modulePath))
            die("module $moduleName aleady exists!\n");

        mkdir($modulePath);
    }

    private function makeRoute(array $args)
    {
        $route = $args[0] ?? null;
        $module = $args[1] ?? null;
        $controller = $args[2] ?? null;
        $action = $args[3] ?? null;

        !is_null($route) ?: $this->error("Not enough arguments (missing: \"route name\").");
        !is_null($module) ?: $this->error("Not enough arguments (missing: \"module name\").");
        !is_null($controller) ?: $this->error("Not enough arguments (missing: \"controller name\").");
        !is_null($action) ?: $this->error("Not enough arguments (missing: \"action name\").");

        $modulesFolder = __DIR__ . "/../../$module";
        $controllersFolder = __DIR__ . "/../../$module/Controllers/$controller.php";

        !file_exists($modulesFolder) ?: $this->error("module $module not found.");
        !file_exists($controllersFolder) ?: $this->error("controller $controller not found.");

        $this->defaultCode->createRoute(
            $route,
            $module,
            $controller,
            $action
        );
    }

    public static function make(string $makeCommand, array $arg)
    {
        $class = new Commands;
        $methodName = "make" . ucfirst($makeCommand);

        call_user_func([$class, $methodName], $arg);
    }
}
