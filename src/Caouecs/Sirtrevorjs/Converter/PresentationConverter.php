<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */
namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Presentation for Sir Trevor Js.
 */
class PresentationConverter extends BaseConverter implements ConverterInterface
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
     *
     * @return array
     */
    public function getJsExternal()
    {
        return [
            'html' => [
                'Issuu' => '<script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>',
            ],
        ];
    }

    /**
     * Slideshare.
     *
     * @return string
     */
    public function slideshareToHtml()
    {
        return $this->view('presentation.slideshare', [
            'remote_id' => $this->data['remote_id'],
        ]);
    }

    /**
     * Issuu.
     *
     * @return string
     */
    public function issuuToHtml()
    {
        return $this->view('presentation.issuu', [
            'remote_id' => $this->data['remote_id'],
        ]);
    }
}
