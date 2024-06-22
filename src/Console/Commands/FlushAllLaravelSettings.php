<?php

namespace DataArkadia\LaravelSettings\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DataArkadia\LaravelSettings\Models\Setting;
use DataArkadia\LaravelSettings\Models\SettingRule;
use DataArkadia\LaravelSettings\Models\SettingValue;
use DataArkadia\LaravelSettings\Models\SettingCategory;

class FlushAllLaravelSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-settings:flush-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all settings data from the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->checkAndInstallSite();
    }

    private function checkAndInstallSite()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        SettingValue::truncate();
        SettingRule::truncate();
        Setting::truncate();
        SettingCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
