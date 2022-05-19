<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\Convertible;
use Exception;
use Log;

/**
 * Images for Sir Trevor Js.
 */
class ImageConverter extends BaseConverter implements Convertible
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
     */
    public function getJsExternal(): array
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
     */
    public function imageToHtml(): string
    {
        if (empty($this->data['file']['url'])) {
            return '';
        }

        $text = $this->data['text'] ?? '';

        if (! empty($text)) {
            $text = $this->parser->toHtml($text);
        }

        $url = $this->data['file']['url'] ?? '';

        try {
            $size = getimagesize($url);
        } catch (Exception $exception) {
            Log::error('ImageConverter::imageToHtml:: '.$exception->getMessage());
        }

        if (empty($size) || ! is_array($size)) {
            $size = [
                $this->config['image.width'] ?? 520,
                $this->config['image.height'] ?? 200,
            ];
        }

        return $this->view('image.image', [
            'url' => $url,
            'text' => $text,
            'width' => $size[0],
            'height' => $size[1],
            'title' => $this->data['title'] ?? '',
        ]);
    }

    /**
     * Converts GettyImage to html.
     */
    public function gettyimagesToHtml(): string
    {
        return $this->view('image.gettyimages', [
            'remote_id' => $this->data['remote_id'],
            'width' => $this->config['gettyimages.width'] ?? 594,
            'height' => $this->config['gettyimages.height'] ?? 465,
            'placeholder' => $this->config['gettyimages.placeholder'] ?? '/',
        ]);
    }

    /**
     * Converts Pinterest to html.
     */
    public function pinterestToHtml(): string
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
