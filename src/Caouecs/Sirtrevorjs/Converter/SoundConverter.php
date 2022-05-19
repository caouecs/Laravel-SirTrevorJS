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
 * Sound for Sir Trevor Js.
 */
class SoundConverter extends BaseConverter implements Convertible
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
     */
    public function getJsExternal(): array
    {
        return [];
    }

    /**
     * Soundcloud block.
     */
    public function soundcloudToHtml(): string
    {
        $theme = $this->config['soundcloud'] ?? '';

        if ($theme !== 'full') {
            $theme = 'small';
        }

        return $this->view('sound.soundcloud.'.$theme, [
            'remote' => $this->data['remote_id'],
        ]);
    }

    /**
     * Spotify block.
     */
    public function spotifyToHtml(): string
    {
        return $this->view('sound.spotify', [
            'remote' => $this->data['remote_id'],
            'options' => $this->config['spotify'],
            'title' => $this->data['title'] ?? 'Spotify',
        ]);
    }
}
