<?php

namespace Ofcold\Module\Setting\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Carbon;
use Ofcold\Module\Setting\{
	Contracts\CacheItemSettingInterface,
	Contracts\SettingCollectionInterface,
	Repositories\SettingRepository,
	SettingStorekey
};

class CacheStoreSetting extends Command
{
	use DispatchesJobs;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'setting:cache';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'In the migrate after and application install before install setting defulat items.';

	protected $repository;

	protected $cache;

	public function __construct()
	{
		parent::__construct();
		$this->repository = app(SettingRepository::class);
		$this->cache = app(CacheItemSettingInterface::class);
	}

	/**
	 * Excute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->repository->all()
			->each(fn ($setting) => $this->cache->setItem($setting->key, $setting));

		$this->info('Cache successfully!');
	}

}
