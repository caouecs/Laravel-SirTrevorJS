<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs;

use Config;
use ParsedownExtra;

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

                switch ($block['type']) {
                    // Blocks Presentation
                    case "slideshare":
                    case "issuu":
                        $converter = new Converter\PresentationConverter($block['type'], $block['data']);
                        $html .= $converter->render($this->codejs);
                        break;
                    // Blocks Modelisation
                    case "sketchfab":
                        $converter = new Converter\Modelisation($block['type'], $block['data']);
                        $html .= $converter->render($this->codejs);
                        break;
                    // Blocks Sound
                    case "soundcloud":
                    case "spotify":
                        $converter = new Converter\SoundConverter($block['type'], $block['data']);
                        $html .= $converter->render($this->codejs);
                        break;
                    // Block Video
                    case "video":
                        $converter = new Converter\VideoConverter($block['data']);
                        $html .= $converter->render($this->codejs);
                        break;
                    // Blocks Images or Services for Images
                    case "image":
                    case "gettyimages":
                    case "pinterest":
                        $converter = new Converter\ImageConverter($block['type'], $block['data']);
                        $html .= $converter->render($this->codejs);
                        break;
                    // Block Embedly
                    case "embedly":
                        $converter = new Converter\EmbedlyConverter($block['data']);
                        $html .= $converter->render($this->codejs);
                        break;
                    // Social Network
                    case "tweet":
                    case "facebook":
                        $converter = new Converter\SocialConverter($block['type'], $block);
                        $html .= $this->render($this->codejs);
                        break;
                    // Default
                    default:
                        $converter = $block['type'] . 'ToHtml';
                        if (is_callable(array($this, $converter))) {
                            // call the function and add the data as parameters
                            $html .= call_user_func_array(
                                array($this, $converter),
                                $block['data']
                            );
                        } else {
                            $markdown = new ParsedownExtra();

                            // Text converter
                            $textConverter = new Converter\TextConverter($markdown);

                            if (is_callable(array($textConverter, $converter))) {
                                $html .= call_user_func_array(
                                    array($textConverter, $converter),
                                    $block['data']
                                );
                            } elseif (array_key_exists('text', $block['data'])) {
                                // we have a text block. Let's just try the default converter
                                $html .= $textConverter->defaultToHtml($block['data']['text']);
                            }
                        }
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
