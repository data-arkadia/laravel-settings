<?php

namespace DataArkadia\LaravelSettings\Console\Commands;

use DataArkadia\LaravelSettings\Models\Site;
use Illuminate\Console\Command;

class InitPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-settings:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kick start this package for your application';

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
        $q1 = 'Would you like to use our method for storing site-specific settings?';
        $q2 = 'This will create a migration for a sites table. Are you sure you want to run a migration now?';

        if ($this->confirm($q1)) {
            if ($this->confirm($q2)) {
                $this->call('vendor:publish', [
                    '--tag' => 'laravel-settings-sites-migration'
                ]);

                $this->call('migrate');

                Site::firstOrCreate([]);
            }
        }
    }
}
