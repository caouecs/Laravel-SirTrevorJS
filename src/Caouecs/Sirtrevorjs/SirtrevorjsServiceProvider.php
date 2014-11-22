<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs;

use Illuminate\Support\ServiceProvider;
use View;

/**
 * Sir Trevor Js service provider
 *
 * @package Caouecs\Sirtrevorjs
 * @see Illuminate\Support\ServiceProvider
 */
class SirtrevorjsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     * @access protected
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @access public
     * @return void
     */
    public function boot()
    {
        $this->package('caouecs/sirtrevorjs');

        include __DIR__.'/../../routes.php';

        View::addNamespace('sirtrevorjs', __DIR__.'/../../views/');
    }

    /**
     * Register the service provider.
     *
     * @access public
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @access public
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
