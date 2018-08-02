<?php

namespace Primas;

use Primas\Kernel\Support\Str;


/**
 * Class Factory
 *
 * @method static \Primas\Account\Application                  account(array $config)
 * @method static \Primas\Content\Application                  content(array $config)
 * @method static \Primas\ContentInteraction\Application       content_interaction(array $config)
 * @method static \Primas\Group\Application                    group(array $config)
 * @method static \Primas\Node\Application                     node(array $config)
 * @method static \Primas\Query\Application                    query(array $config)
 * @method static \Primas\System\Application                   system(array $config)
 * @method static \Primas\TimeLine\Application                 time_line(array $config)
 * @method static \Primas\Token\Application                    token(array $config)
 *
 * @package Primas
 */
class Factory
{
    /**
     * @param $name
     * @param array $config
     * @return mixed
     */
    public static function make($name, array $config)
    {
        $namespace = Str::studly($name);
        $application = "\\Primas\\{$namespace}\\Application";
        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}