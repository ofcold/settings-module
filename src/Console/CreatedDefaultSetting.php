<?php

namespace Ofcold\Module\Setting\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Carbon;
use Ofcold\Module\Setting\Contracts\CreateSettingItemInterface;
use Ofcold\Module\Setting\Contracts\SettingCollectionInterface;
use Ofcold\Module\Setting\Contracts\SettingInterface;
use Ofcold\Module\Setting\SettingStorekey;

class CreatedDefaultSetting extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:create';

    protected int $count = 0;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In the migrate after and application install before install setting defulat items.';

    protected $creator;
    protected $settings;

    public function __construct()
    {
        parent::__construct();
        $this->creator = app(CreateSettingItemInterface::class);
        $this->settings = app(SettingCollectionInterface::class);
    }

    /**
     * Excute the command.
     *
     * @return void
     */
    public function handle()
    {
        $settings = $this->settings->all();

        foreach ($settings as $namespace => $items) {
            foreach ($items as $key => $vals) {
                go(fn () => $this->generateItems($namespace, $key, $vals));
            }
        }

        $this->info('Successfully create count: ' . $this->count);
    }

    protected function generateItems($namespace, $key, $vals)
    {
        foreach ($vals as $val) {

            $response = $this->creator->create([
                'key' => $namespace.'::'.$key.'.'.$val['key'],
                'namespace' => $namespace,
                'component' => $val['component'],
                'value' => $val['value'] ?? null,
                'defulat' => $val['value'] ?? $val['defulat'] ?? null,
            ]);

            if ($response instanceof SettingInterface) {
                $this->count++;
            }
        }
    }
}
