<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\Convertible;

/**
 * Modelisation for Sir Trevor Js.
 */
class ModelisationConverter extends BaseConverter implements Convertible
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
     */
    public function getJsExternal(): array
    {
        return [];
    }

    /**
     * Sketchfab block.
     */
    public function sketchfabToHtml(): string
    {
        return $this->view('modelisation.sketchfab', [
            'remote_id' => $this->data['remote_id'],
            'title' => $this->data['title'] ?? 'Sketchfab',
        ]);
    }
}
