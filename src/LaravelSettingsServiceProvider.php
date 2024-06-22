<?php

namespace DataArkadia\LaravelSettings;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use DataArkadia\LaravelSettings\Models\Setting;
use DataArkadia\LaravelSettings\Models\SettingValue;
use DataArkadia\LaravelSettings\Models\SettingCategory;
use DataArkadia\LaravelSettings\Policies\SettingPolicy;
use DataArkadia\LaravelSettings\Observers\SettingValueObserver;
use DataArkadia\LaravelSettings\Policies\SettingCategoryPolicy;
use DataArkadia\LaravelSettings\Console\Commands\FlushAllLaravelSettings;

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
        $this->registerViews();
    }

    private function publishMigrations(): void
    {
        //
    }

    private function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FlushAllLaravelSettings::class,
            ]);
        }
    }

    private function publishConfigs(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-settings.php'),
            ], 'laravel-settings-config');
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

    private function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-settings');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-settings'),
        ], 'laravel-settings-views');
    }
}
