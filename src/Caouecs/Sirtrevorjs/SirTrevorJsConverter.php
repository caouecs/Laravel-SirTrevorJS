<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
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
     * Code JS needed by elements
     *
     * @access protected
     * @var array
     */
    protected $codejs = null;

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

        if (!empty($input) && is_array($input)) {
            // loop trough the data blocks
            foreach ($input['data'] as $block) {
                // no data, problem
                if (!isset($block['data'])) {
                    break;
                }

                $converter = null;

                switch ($block['type']) {
                    // Blocks Presentation
                    case "slideshare":
                    case "issuu":
                        $converter = new Converter\PresentationConverter($block['type'], $block['data']);
                        break;
                    // Blocks Modelisation
                    case "sketchfab":
                        $converter = new Converter\ModelisationConverter($block['type'], $block['data']);
                        break;
                    // Blocks Sound
                    case "soundcloud":
                    case "spotify":
                        $converter = new Converter\SoundConverter($block['type'], $block['data']);
                        break;
                    // Block Video
                    case "video":
                        $converter = new Converter\VideoConverter($block['data']);
                        break;
                    // Blocks Images or Services for Images
                    case "image":
                    case "gettyimages":
                    case "pinterest":
                        $converter = new Converter\ImageConverter($block['type'], $block['data']);
                        break;
                    // Block Embedly
                    case "embedly":
                        $converter = new Converter\EmbedlyConverter($block['type'], $block['data']);
                        break;
                    // Social Network
                    case "tweet":
                    case "facebook":
                        $converter = new Converter\SocialConverter($block['type'], $block);
                        break;
                    // Text blocks
                    default:
                        // Text converter
                        $converter = new Converter\TextConverter($block['type'], $block['data']);
                }
                
                if (isset($converter)) {
                    $html .= $this->render($this->codejs);
                }
            }

            // code js
            if (!empty($this->codejs) && is_array($this->codejs)) {
                foreach ($this->codejs as $arr) {
                    $html .= $arr;
                }
            }
        }

        return $html;
    }
}
