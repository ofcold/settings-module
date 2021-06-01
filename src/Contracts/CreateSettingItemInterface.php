<?php

namespace Ofcold\Module\Setting\Contracts;

interface CreateSettingItemInterface
{
    /**
     * Save the setting item.
     *
     * @param  SettingInterface $setting
     * @param  array $items
     *
     * @return mixed
     */
    public function create(SettingInterface $setting, array $items);
}
