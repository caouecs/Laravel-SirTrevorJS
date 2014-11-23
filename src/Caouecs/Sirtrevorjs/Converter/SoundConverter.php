<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Config;
use View;

/**
 * Sound for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class SoundConverter
{
    /**
     * Type of sound
     *
     * @var string
     * @access protected
     */
    protected $type = null;

    /**
     * Data of sound
     *
     * @var array
     * @access protected
     */
    protected $data = null;

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
     * Construct
     *
     * @access public
     * @param string $type Type of sound
     * @param array $data Data of sound
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Render of sound
     *
     * @access public
     * @param array $codejs Array of js
     * @return string
     */
    public function render(&$codejs)
    {
        if (in_array($this->type, $this->types)) {
            return call_user_func_array(
                array($this, $this->type."ToHtml"),
                array($codejs)
            );
        }

        return null;
    }

    /**
     * Soundcloud block
     *
     * @access public
     * @return string
     */
    public function soundcloud()
    {
        $config = Config::get("sirtrevorjs::sir-trevor-js");

        $theme = (isset($config['soundcloud']) && $config['soundcloud'] === "full") ? "full" : "small";

        return View::make("sirtrevorjs::sound.soundcloud.".$theme, array(
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
        return View::make("sirtrevorjs::sound.spotify", array(
            "remote" => $this->data['remote_id'],
            "options" => Config::get("sirtrevorjs::spotify")
        ));
    }
}
