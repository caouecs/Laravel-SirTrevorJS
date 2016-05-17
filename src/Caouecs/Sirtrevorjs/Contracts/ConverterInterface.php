<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Contracts;

/**
 * Interface ConverterInterface.
 */
interface ConverterInterface
{
    /**
     * Render.
     *
     * @return mixed
     */
    public function render();

    /**
     * Return array js external.
     *
     * @return array
     */
    public function getJsExternal();
}
