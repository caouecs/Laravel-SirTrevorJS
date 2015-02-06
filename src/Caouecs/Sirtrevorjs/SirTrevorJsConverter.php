<?php
/**
 * Laravel-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use Config;

/**
 * Class Converter
 *
 * A Sir Trevor to HTML conversion helper for PHP
 * inspired by work of Wouter Sioen <info@woutersioen.be>
 *
 * @package Caouecs\Sirtrevorjs
 */
class SirTrevorJsConverter
{
    /**
     * Valid blocks with converter
     *
     * @access protected
     * @var array
     */
    protected $blocks = array(
        "blockquote"    => "Text",
        "embedly"       => "Embedly",
        "facebook"      => "Social",
        "gettyimages"   => "Image",
        "heading"       => "Text",
        "image"         => "Image",
        "issuu"         => "Presentation",
        "markdown"      => "Text",
        "pinterest"     => "Image",
        "quote"         => "Text",
        "sketchfab"     => "Modelisation",
        "slideshare"    => "Presentation",
        "soundcloud"    => "Sound",
        "spotify"       => "Sound",
        "text"          => "Text",
        "tweet"         => "Social",
        "video"         => "Video"
    );

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {
        $this->config = Config::get("sirtrevorjs::sir-trevor-js");
    }

    /**
     * Converts the outputted json from Sir Trevor to html
     *
     * @access public
     * @param string $json
     * @return string
     */
    public function toHtml($json)
    {
        // convert the json to an associative array
        $input = json_decode($json, true);
        $html  = null;
        $codejs = null;

        if (is_array($input)) {
            // loop trough the data blocks
            foreach ($input['data'] as $block) {
                // no data, problem
                if (!isset($block['data']) || !array_key_exists($block['type'], $this->blocks)) {
                    break;
                }

                $class = "Caouecs\\Sirtrevorjs\\Converter\\".$this->blocks[$block['type']]."Converter";

                $converter = new $class($this->config, $block);
                $html .= $converter->render($codejs);
            }

            // code js
            if (is_array($codejs)) {
                $html .= implode($codejs);
            }
        }

        return $html;
    }
}
