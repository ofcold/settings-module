<?php

namespace Ofcold\Module\Setting\Contracts;

interface CreateSettingItemInterface
{
    /**
     * Save the setting item.
     *
     * @param  array $items
     *
     * @return mixed
     */
    public function create(array $items);
}
