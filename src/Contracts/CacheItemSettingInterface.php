<?php

namespace Ofcold\Module\Setting\Contracts;

interface CacheItemSettingInterface
{
    /**
     * Store an item in the cache if the key doesn't exist.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return bool
     */
    public function setItem(string $key, $value): bool;

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array  $key
     *
     * @return mixed
     */
    public function item(string $key);

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function forget($key): bool;

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush(): bool;

    /**
     * Get the connection for the setting connection.
     *
     * @return \Illuminate\Redis\Connections\Connection
     */
    public function connection();

    /**
     * Set the setting connection name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setConnectionName(string $name): void;
}
