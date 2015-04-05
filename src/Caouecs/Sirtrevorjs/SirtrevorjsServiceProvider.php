<?php
/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use Illuminate\Support\ServiceProvider;
use View;

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
    public function boot()
    {
        $this->package('caouecs/sirtrevorjs');

        include __DIR__.'/../../routes.php';

        View::addNamespace('sirtrevorjs', __DIR__.'/../../views/');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
