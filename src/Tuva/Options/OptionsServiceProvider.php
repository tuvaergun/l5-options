<?php namespace Tuva\Options;

use Illuminate\Support\ServiceProvider;

class OptionsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/option.php' => config_path('option.php')
        ]);
        $this->publishes([
            __DIR__ . '/../../migrations/' => base_path('/database/migrations')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/option.php', 'options'
        );
        $this->app['options'] = $this->app->share(function ($app) {

            $config = $app->config->get('options', [
                'cache_file' => storage_path('options.json'),
                'db_table'   => 'options'
            ]);

            return new Options($app['db'], new Cache($config['cache_file']), $config);
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array ('options');
    }

}