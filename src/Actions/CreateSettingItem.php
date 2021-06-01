<?php

namespace Ofcold\Module\Setting\Actions;

use Ofcold\Module\Setting\Models\Setting;
use Ofcold\Module\Setting\Repositories\SettingRepository;
use Ofcold\Module\Setting\Contracts\CreateSettingItemInterface;

class CreateSettingItem implements CreateSettingItemInterface
{
    public function __construct(protected SettingRepository $repository)
    {
    }

    /**
     * Save the setting item.
     *
     * @param  array $items
     *
     * @return mixed
     */
    public function create(array $items)
    {
        if ($repository->hasKeyExists($items['key'])) {
            return;
        }

        $items['is_bind_env'] = config()->has($items['is_bind_env']);

        return Setting::create($items);
    }
}
