<?php

namespace Core\Console;

class Manual
{
    public static function Help()
    {
        $banner =
            Color::$TEXT_ORANG . " make\n" . Color::$END .
            Color::$TEXT_GREEN . "\tmake:module" . Color::$END .
            "\t\t[module]\n" .

            Color::$TEXT_GREEN . "\tmake:controller" . Color::$END .
            "\t\t[module] [controller]\n" .

            Color::$TEXT_GREEN . "\tmake:view" . Color::$END .
            "\t\t[module] [view controller] [view]\n" .

            Color::$TEXT_GREEN . "\tmake:action" . Color::$END .
            "\t\t[module] [controller] [action] [view controller] [view]\n" .

            Color::$TEXT_GREEN . "\tmake:route" . Color::$END .
            "\t\t[route] [module] [controller] [action]\n" .

            Color::$TEXT_GREEN . "\tmake:model" . Color::$END .
            "\t\t[module] [model]\n"

            . Color::$END;

        echo $banner;

        exit;
    }
}
