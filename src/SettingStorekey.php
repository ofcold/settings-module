<?php

namespace Ofcold\Module\Setting;

class SettingStorekey
{
    public static function get(string $key): string
    {
        return 'Ofcold__Setting-module@' . $key;
    }
}
