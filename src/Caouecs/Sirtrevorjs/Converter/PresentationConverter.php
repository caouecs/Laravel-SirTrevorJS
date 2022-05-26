<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\Convertible;

/**
 * Presentation for Sir Trevor Js.
 */
class PresentationConverter extends BaseConverter implements Convertible
{
    /**
     * List of types for presentation.
     *
     * @var array
     */
    protected $types = [
        'slideshare',
        'issuu',
    ];

    /**
     * Return array js external.
     */
    public function getJsExternal(): array
    {
        return [
            'html' => [
                'Issuu' => '<script type="text/javascript" src="https://e.issuu.com/embed.js" async="true"></script>',
            ],
        ];
    }

    /**
     * Slideshare.
     */
    public function slideshareToHtml(): string
    {
        return $this->view('presentation.slideshare', [
            'remote_id' => $this->data['remote_id'],
            'title' => $this->data['title'] ?? 'Slideshare',
        ]);
    }

    /**
     * Issuu.
     */
    public function issuuToHtml(): string
    {
        return $this->view('presentation.issuu', [
            'remote_id' => $this->data['remote_id'],
        ]);
    }
}
