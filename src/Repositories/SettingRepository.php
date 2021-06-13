<?php

namespace Ofcold\Module\Setting\Repositories;

use Illuminate\Database\ConnectionInterface;
use Ofcold\Module\Setting\Contracts\CacheItemSettingInterface;
use Ofcold\Module\Setting\GenericSetting;
use Illuminate\Support\LazyCollection;
use Illuminate\Contracts\Config\Repository as ConfigurationInterface;

class SettingRepository
{
	/**
	 * Create a new MemberRepository member repository instance.
	 *
	 * @param  \Illuminate\Database\ConnectionInterface  $conn
	 * @param  \Ofcold\Module\Setting\Contracts\CacheItemSettingInterface  $cache
	 * @param  \Illuminate\Contracts\Config\Repository  $config
	 * @param  string|null  $table
	 *
	 * @return void
	 */
	public function __construct(
		protected ConnectionInterface $conn,
		protected CacheItemSettingInterface $cache,
		protected ConfigurationInterface $config,
		protected ?string $table = null
	) {
		$this->table = $this->table ?: 'settings';
	}

	/**
	 * Find the item by key.
	 *
	 * @param  string $key
	 *
	 * @return mixed
	 */
	public function item(string $key): GenericSetting
	{
		$item = $this->cache->item($key);

		return $item ?: $this->getGenericSetting(
			$this->conn->table($this->table)
				->where('key', $key)
				->first()
		);
	}

	public function hasKeyExists(string $key): bool
	{
		return $this->conn->table($this->table)
				->where('key', $key)
				->count() > 0;
	}

	/**
	 * Get the setting collection by namespace.
	 *
	 * @param  string $namespace
	 *
	 * @return Collectioon
	 */
	public function namespace(string $namespace)
	{
		return $this->conn->table($this->table)
			->where('namespace', $namespace)
			->cursor()
			->map(fn ($entry) => $this->getGenericSetting($entry));
	}

	/**
	 * Begin querying the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query()
	{
		return $this->conn->table($this->table);
	}

	/**
	 * Get all of the items in the collection.
	 *
	 * @return array|LazyCollection
	 */
	public function all(): LazyCollection
	{
		return $this->conn->table($this->table)
			->cursor()
			->map(fn ($entry) => $this->getGenericSetting($entry));
	}

	/**
	 * Get the generic setting.
	 *
	 * @param  mixed  $user
	 *
	 * @return \Ofcold\Module\Setting\GenericSetting
	 */
	protected function getGenericSetting($entry)
	{
		return new GenericSetting((array) $entry);
	}
}
