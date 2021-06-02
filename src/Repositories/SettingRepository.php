<?php

namespace Ofcold\Module\Setting\Repositories;

use Illuminate\Database\ConnectionInterface;
use Ofcold\Module\Setting\GenericSetting;
use Ofcold\Module\Setting\SettingStorekey;

class SettingRepository
{
    /**
     * Create a new MemberRepository member repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $conn
     * @param  string|null  $table
     *
     * @return void
     */
    public function __construct(
        protected ConnectionInterface $conn,
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
        return $this->getGenericSetting(
            $this->conn->table($this->table)
                ->where('key', SettingStorekey::get($key))
                ->first()
        );
    }

    public function hasKeyExists(string $key): bool
    {
        return $this->conn->table($this->table)
                ->where('key', SettingStorekey::get($key))
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

    public function query()
    {
        return $this->conn->table($this->table);
    }

    public function all()
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
