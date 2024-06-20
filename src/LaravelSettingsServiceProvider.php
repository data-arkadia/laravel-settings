<?php

namespace DataArkadia\LaravelSettings;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use DataArkadia\LaravelSettings\Models\Setting;
use DataArkadia\LaravelSettings\Models\SettingValue;
use DataArkadia\LaravelSettings\Models\SettingCategory;
use DataArkadia\LaravelSettings\Policies\SettingPolicy;
use DataArkadia\LaravelSettings\Console\Commands\InitPackage;
use DataArkadia\LaravelSettings\Observers\SettingValueObserver;
use DataArkadia\LaravelSettings\Policies\SettingCategoryPolicy;

class LaravelSettingsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Setting::class => SettingPolicy::class,
        SettingCategory::class => SettingCategoryPolicy::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-settings');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app->singleton('SettingManager', function ($app) {
            return new SettingManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishMigrations();
        $this->bootCommands();
        $this->publishConfigs();
        $this->bootBladeDirectives();
        $this->bootModelObservers();
    }

    private function publishMigrations(): void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/optional' => database_path('migrations'),
        ], 'laravel-settings-sites-migration');
    }

    private function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InitPackage::class,
            ]);
        }
    }

    private function publishConfigs(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-settings.php'),
            ], 'config');
        }
    }

    private function bootBladeDirectives(): void
    {
        Blade::directive('setting', function ($value) {
            return "<?php echo setting($value); ?>";
        });
    }

    private function bootModelObservers(): void
    {
        SettingValue::observe(SettingValueObserver::class);
    }
}
