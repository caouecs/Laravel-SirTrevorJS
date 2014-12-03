<?php namespace Caouecs\Sirtrevorjs\Contracts;

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