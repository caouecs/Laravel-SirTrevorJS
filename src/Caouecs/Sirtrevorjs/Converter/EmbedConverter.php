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
 * Embed for Sir Trevor Js.
 */
class EmbedConverter extends BaseConverter implements Convertible
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
     */
    public function getJsExternal(): array
    {
        return [
            'html' => [
                'embedly' => '<script async src="https://cdn.embedly.com/widgets/platform.js" charset="UTF-8">'
                    .'</script>',
            ],
            'amp' => [
                'iframe' => '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/'
                    .'amp-iframe-0.1.js"></script>',
            ],
        ];
    }

    /**
     * Render of iframe.
     */
    public function iframeToHtml(): string
    {
        return $this->view('embed.iframe', [
            'src' => $this->data['src'],
            'width' => $this->data['width'],
            'height' => $this->data['height'],
            'title' => $this->data['title'] ?? '',
        ]);
    }

    /**
     * Render of embedly.
     */
    public function embedlyToHtml(): string
    {
        if (filter_var($this->data['url'], FILTER_VALIDATE_URL)) {
            return $this->view('embedly.'.$this->type, [
                'url' => $this->data['url'],
                'options' => $this->config['embedly'] ?? '',
            ]);
        }

        return '';
    }
}
