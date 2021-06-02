<?php

namespace Ofcold\Module\Setting\Actions;

use Illuminate\Contracts\Redis\Factory as Redis;
use Ofcold\Module\Setting\Contracts\CacheItemSettingInterface;
use Ofcold\Module\Setting\SettingStorekey;

class CacheItemSetting implements CacheItemSettingInterface
{
    public function __construct(
        protected Redis $redis,
        protected string $connectionName = 'setting'
    ) {
    }

    /**
     * Store an item in the cache if the key doesn't exist.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return bool
     */
    public function setItem(string $key, $value): bool
    {
        return (bool) $this->connection()->setnx(
            $key, $this->serialize($value)
        );
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array  $key
     *
     * @return mixed
     */
    public function getItem(string $key)
    {
        $value = $this->connection()->get(SettingStorekey::get($key));

        return ! is_null($value) ? $this->unserialize($value) : null;
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function forget($key): bool
    {
        return (bool) $this->connection()->del($key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush(): bool
    {
        $this->connection()->flushdb();

        return true;
    }

    /**
     * Get the connection for the setting connection.
     *
     * @return \Illuminate\Redis\Connections\Connection
     */
    public function connection()
    {
        return $this->redis->connection($this->connectionName);
    }

    /**
     * Serialize the value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function serialize($value)
    {
        return is_numeric($value) && ! in_array($value, [INF, -INF]) && ! is_nan($value) ? $value : serialize($value);
    }

    /**
     * Unserialize the value.
     *
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function unserialize($value)
    {
        return is_numeric($value) ? $value : unserialize($value);
    }

    /**
     * Set the setting connection name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setConnectionName(string $name): void
    {
        $this->connectionName = $name;
    }
}
