<?php

namespace Ofcold\Module\Setting;

use Ofcold\Extension\Module\AbstractModule;

class SettingModule extends AbstractModule
{
    /**
     * Get the version number of the member module.
     *
     * @return string
     */
    public static function version(): string
    {
        return '0.1.0';
    }

    /**
     * Return to the Member module path.
     *
     * @param  string $path
     *
     * @return string
     */
    public static function modulePath(?string $path = null): string
    {
        $main = __DIR__.'/../';

        return $path ? $main.ltrim($path, '/') : $main;
    }
}
