<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;
use Exception;

/**
 * Images for Sir Trevor Js.
 */
class ImageConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types.
     *
     * @var array
     */
    protected $types = [
        'image',
        'gettyimages',
        'pinterest',
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
                'pinterest' => '<script type="text/javascript" async src="https://assets.pinterest.com/js/pinit.js">'
                    .'</script>',
            ],
            'amp' => [
                'gettyimages' => '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/'
                    .'amp-iframe-0.1.js"></script>',
            ],
        ];
    }

    /**
     * Converts the image to html.
     *
     * @return string
     */
    public function imageToHtml()
    {
        if (is_null(array_get($this->data, 'file.url'))) {
            return '';
        }

        $text = array_get($this->data, 'text');

        if (!empty($text)) {
            $text = $this->parser->toHtml($text);
        }

        $url = array_get($this->data, 'file.url');

        try {
            $size = getimagesize($url);
        } catch (Exception $e) {
            $size = [
                array_get($this->config, 'image.width', 520),
                array_get($this->config, 'image.height', 200),
            ];
        }

        return $this->view('image.image', [
            'url' => $url,
            'text' => $text,
            'width' => $size[0],
            'height' => $size[1],
        ]);
    }

    /**
     * Converts GettyImage to html.
     *
     * @return string
     */
    public function gettyimagesToHtml()
    {
        return $this->view('image.gettyimages', [
            'remote_id' => $this->data['remote_id'],
            'width' => array_get($this->config, 'gettyimages.width', 594),
            'height' => array_get($this->config, 'gettyimages.height', 465),
            'placeholder' => array_get($this->config, 'gettyimages.placeholder', '/'),
        ]);
    }

    /**
     * Converts Pinterest to html.
     *
     * @return string
     */
    public function pinterestToHtml()
    {
        /*
         * Pin
         */
        if ($this->data['provider'] === 'pin') {
            return $this->view('image.pin', [
                'remote_id' => $this->data['remote_id'],
            ]);
        }

        return '';
    }
}
