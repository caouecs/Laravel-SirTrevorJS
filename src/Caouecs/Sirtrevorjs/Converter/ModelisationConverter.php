<?php
/**
 * Laravel-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Modelisation for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class ModelisationConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types for modelisation
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "sketchfab"
    );

    /**
     * Sketchfab block
     *
     * @access public
     * @return string
     */
    public function sketchfabToHtml()
    {
        return $this->view("modelisation.sketchfab", array(
            "remote_id" => $this->data['remote_id']
        ));
    }
}
