<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Modelisation for Sir Trevor Js.
 */
class ModelisationConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types for modelisation.
     *
     * @var array
     */
    protected $types = [
        'sketchfab',
    ];

    /**
     * Return array js external.
     *
     * @return array
     */
    public function getJsExternal()
    {
        return [];
    }

    /**
     * Sketchfab block.
     *
     * @return string
     */
    public function sketchfabToHtml()
    {
        return $this->view('modelisation.sketchfab', [
            'remote_id' => $this->data['remote_id'],
        ]);
    }
}
