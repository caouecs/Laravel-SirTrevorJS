<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use Caouecs\Sirtrevorjs\Parser\LaravelParser;
use Illuminate\Support\ServiceProvider;

/**
 * Sir Trevor Js service provider.
 */
class SirtrevorjsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'sirtrevorjs');

        $this->publishes([
            __DIR__.'/../../config/sir-trevor-js.php' => config_path('sir-trevor-js.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind('caouecs.sirtrevorjs.converter', function () {
            return new SirTrevorJsConverter(
                new LaravelParser(),
                config('sir-trevor-js'),
                'html'
            );
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
