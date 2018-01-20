<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Sound for Sir Trevor Js.
 */
class SoundConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types for sound.
     *
     * @var array
     */
    protected $types = [
        'soundcloud',
        'spotify',
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
     * Soundcloud block.
     *
     * @return string
     */
    public function soundcloudToHtml()
    {
        $theme = $this->config['soundcloud'] ?? '';

        if ('full' !== $theme) {
            $theme = 'small';
        }

        return $this->view('sound.soundcloud.'.$theme, [
            'remote' => $this->data['remote_id'],
        ]);
    }

    /**
     * Spotify block.
     *
     * @return string
     */
    public function spotifyToHtml()
    {
        return $this->view('sound.spotify', [
            'remote' => $this->data['remote_id'],
            'options' => $this->config['spotify'],
        ]);
    }
}
