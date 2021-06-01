<?php

namespace Ofcold\Module\Setting\Actions;

use Illuminate\Http\Request;
use Ofcold\Module\Setting\Repositories\SettingRepository;

class UpdateSettingItem implements UpdateSettingItemInterface
{
    public function __construct(
        protected Request $request,
        protected SettingRepository $repository
    ) {
    }

    public function save(SettingInterface $setting, array $items)
    {
        $user = $request->user();

        foreach ($items as $field => $value) {
            if ($field !== 'key' && $setting?->$field && $setting->$field !== $value) {
                $setting->$field = $value;
            }
        }

        $setting->push();

        $logs = new SettingsStoreLogs;

        $logs->entry_id = $user->id();
        $logs->entry_type = $user::class;
        $logs->setting_key = $setting->key;
        $logs->modifed = $items;
        $logs->save();

        return $setting->refresh();
    }
}
