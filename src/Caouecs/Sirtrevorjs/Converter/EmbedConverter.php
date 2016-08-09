<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Embed for Sir Trevor Js.
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
     * Return array of js external.
     *
     * @return array
     */
    public function getJsExternal()
    {
        return [
            'html' => [
                'embedly' => '<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>',
            ],
            'amp' => [
                'iframe' => '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/'
                    .'amp-iframe-0.1.js"></script>',
            ],
        ];
    }

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
     * @return string
     */
    public function embedlyToHtml()
    {
        if (filter_var($this->data['url'], FILTER_VALIDATE_URL)) {
            return $this->view('embedly.'.$this->type, [
                'url' => $this->data['url'],
                'options' => array_get($this->config, 'embedly'),
            ]);
        }

        return '';
    }
}
