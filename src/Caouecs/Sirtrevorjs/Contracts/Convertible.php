<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Contracts;

/**
 * Interface Convertible.
 */
interface Convertible
{
    /**
     * Render.
     *
     * @return mixed
     */
    public function render();

    /**
     * Return array js external.
     */
    public function getJsExternal(): array;
}
