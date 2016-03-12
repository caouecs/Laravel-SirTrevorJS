<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Embedly for Sir Trevor Js.
 */
class EmbedConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types.
     *
     * @var array
     */
    protected $types = [
        'embedly',
        'iframe',
    ];

    /**
     * Render of iframe.
     *
     * @return string
     */
    public function iframeToHtml()
    {
        return $this->view('embed.iframe', [
            'src' => $this->data['src'],
            'width' => $this->data['width'],
            'height' => $this->data['height'],
        ]);
    }

    /**
     * Render of embedly.
     *
     * @param array $codejs Array of js
     *
     * @return string
     */
    public function embedlyToHtml(&$codejs)
    {
        if (filter_var($this->data['url'], FILTER_VALIDATE_URL)) {
            $codejs['embedly'] = '<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>';

            return $this->view('embedly.'.$this->type, [
                'url'     => $this->data['url'],
                'options' => array_get($this->config, 'embedly'),
            ]);
        }

        return;
    }
}
