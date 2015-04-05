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
     * @param $codejs
     *
     * @return mixed
     */
    public function render(&$codejs);
}
