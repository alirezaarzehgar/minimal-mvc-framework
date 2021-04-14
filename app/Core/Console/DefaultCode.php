<?php

namespace Core\Console;

class DefaultCode
{
    public function createView(string $viewPath, string $viewName)
    {
        $file = fopen("$viewPath/$viewName.php", 'w');

        $viewCode = "
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>$viewName</title>
</head>
<body>
    <h1>$viewName</h1>
</body>
</html>
        ";

        fwrite($file, $viewCode);

        fclose($file);
    }

    public function createModel(string $modelPath, string $module, string $modelName)
    {
        $className = ucfirst($modelName);
        $file = fopen("$modelPath/$className.php", 'w');

        $modelCode = "<?php

namespace $module\Models;

class $className
{

}";

        fwrite($file, $modelCode);

        fclose($file);
    }

    public function addAutoload(string $module)
    {
        $keyword = "$module\\";
        $composerFile = fopen(__DIR__ . "/../../../composer.json", "r");
        $composerContents = fread($composerFile, 10240);
        fclose($composerFile);

        $composerFile = fopen(__DIR__ . "/../../../composer.json", "w");

        $json = json_decode($composerContents);
        if (!isset($json->{"autoload"}->{"psr-4"}->{$keyword})) {
            $json->{"autoload"}->{"psr-4"}->{$keyword} = "app/$module";
        }

        fwrite($composerFile, json_encode($json, JSON_PRETTY_PRINT));

        fclose($composerFile);
    }

    public function createController(string $controllerPath, string $module, string $controllerName)
    {
        $className = ucfirst($controllerName);
        $file = fopen("$controllerPath/$className.php", 'w');

        $modelCode = "<?php

namespace $module\Controllers;
        
use Core\BaseController;

class $className extends BaseController
{

}";

        fwrite($file, $modelCode);

        fclose($file);
    }

    public function createAction(
        string $controllerFile,
        string $actionName,

        string $module,
        string $controller,
        string $view
    ) {
        $readFile = fopen($controllerFile, "r");

        $fileSource = fread($readFile, 10240);

        if (strpos($fileSource, "public function $actionName"))
            return false;

        $endOfClass = explode("\n", $fileSource);

        $additionalSource = "    public function $actionName()
    {
        parent::renderView('$module', '$controller', '$view');
    }
}";

        for ($index = 0; $index < count($endOfClass); $index++) {
            if (
                $endOfClass[$index] == "}" and
                $index > count($endOfClass) - 4
            ) {
                $endOfClass[$index] = $additionalSource;
            }
        }

        fclose($readFile);

        $finalSource = implode("\n", $endOfClass);

        $readFile = fopen($controllerFile, "w");

        fwrite($readFile, $finalSource);

        fclose($readFile);
    }

    public function createRoute(
        string $route,
        string $module,
        string $controller,
        string $action
    ) {

        $readFile = fopen(__DIR__ . "/../Routing.php", "r");
        $allSource = fread($readFile, 10240);

        $writeFile = fopen(__DIR__ . "/../Routing.php", "w");

        $newRoute = "
        [
            'route' => '$route',
            'module' => '$module',
            'controller' => '$controller',
            'action' => '$action',
        ],
    ];";


        $sepratedByLine = explode("\n", $allSource);

        $openedFlag = false;

        for ($i = 0; $i < count($sepratedByLine); $i++) {
            if (strpos($sepratedByLine[$i], "public \$routes = ["))
                $openedFlag = true;

            if ($openedFlag and strpos($sepratedByLine[$i], "];")) {
                $sepratedByLine[$i] = $newRoute;
                break;
            }
        }

        fwrite($writeFile, implode("\n", $sepratedByLine));

        fclose($readFile);
        fclose($writeFile);
    }
}
