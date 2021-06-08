<?php

namespace Ofcold\Module\Setting\Actions;

use Illuminate\Http\Request;
use Ofcold\Module\Setting\Repositories\SettingRepository;

class UpdateSettingItem implements UpdateSettingItemInterface
{
    use CreateSettingStoreLog;

    public function __construct(
        protected Request $request,
        protected SettingRepository $repository
    ) {
    }

    public function push(string $key, array $items)
    {
        return with($this->repository->hasKeyExists($key), function() {
            $user = $this->request->user();

            $this->repository->query()
                ->update(
                    array_filter($items, fn($field) => $field !== 'key', ARRAY_FILTER_USE_KEY)
                )
                ->where('key', $key);

            $this->createLog([
                'entry_id' => $user->id,
                'entry_type' => $user::class,
                'setting_key' => $setting->key,
                'modifed' => $items,
            ]);
        });
    }
}
