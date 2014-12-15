<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Contracts;

/**
 * Interface ConverterInterface
 *
 * @package Caouecs\Sirtrevorjs\Contracts
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
