<?php

namespace Ofcold\Module\Setting;

use Illuminate\Support\Collection;
use Ofcold\Component\Support\DirectoryFiles;
use Ofcold\Module\Setting\Contracts\SettingCollectionInterface;

class SettingCollection extends Collection implements SettingCollectionInterface
{
    /**
     * Add a namespace to settings.
     *
     * @param string $namespace
     * @param $directory
     *
     * @return void
     */
    public function addNamespace(string $namespace, string $directory): void
    {
        $files = DirectoryFiles::make($directory);

        $items = [];

        foreach ($files as $key => $path) {
            $items[$key] = require $path;
        }

        $this->put($namespace, $items);
    }

    public function findByModule(string $namespace): static
    {
        return new static($this->get($namespace));
    }
}
