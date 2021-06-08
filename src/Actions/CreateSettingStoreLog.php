<?php

namespace Ofcold\Module\Setting\Actions;

trait CreateSettingStoreLog
{
	protected function createLog(array $input): SettingsStoreLog
	{
		return SettingsStoreLog::create($input);
	}
}