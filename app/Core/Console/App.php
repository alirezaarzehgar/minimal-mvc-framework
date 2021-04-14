<?php

namespace Core\Console;

class App
{
    public function __construct()
    {
        $commands = new Commands;
        $args = $_SERVER['argv'];
        $firstArg = explode(':', $args[1]);
        $parameters = array_slice($args, 2);

        if ($firstArg[0] == 'serve') {
            $commands->serve($parameters);
        } elseif ($firstArg[0] == 'make') {
            foreach (Commands::$commands['make'] as $makeCommand) {
                if ($makeCommand == ($firstArg[1] ?? null))
                    $commands->make($firstArg[1], $parameters);
            }
        }
    }
}
