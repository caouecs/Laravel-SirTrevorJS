<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

/**
 * Sound for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class SoundConverter extends BaseConverter
{
    /**
     * List of types for sound
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "spotify"
    );

    /**
     * Soundcloud block
     *
     * @access public
     * @return string
     */
    public function soundcloudToHtml()
    {
        $theme = (isset($this->config['soundcloud']) && $this->config['soundcloud'] === "full") ? "full" : "small";

        return $this->view("sound.soundcloud.".$theme, array(
            "remote" => $this->data['remote_id']
        ));
    }

    /**
     * Spotify block
     *
     * @access public
     * @return string
     */
    public function spotifyToHtml()
    {
        return $this->view("sound.spotify", array(
            "remote" => $this->data['remote_id'],
            "options" => $this->config['spotify']
        ));
    }
}
