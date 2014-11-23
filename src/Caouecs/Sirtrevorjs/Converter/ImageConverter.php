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
 * Images for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class ImageConverter
{
    /**
     * Type of image
     *
     * @var string
     * @access protected
     */
    protected $type = null;

    /**
     * Data of image
     *
     * @var array
     * @access protected
     */
    protected $data = null;

    /**
     * List of types
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "image",
        "gettyimages",
        "pinterest"
    );

    /**
     * Construct
     *
     * @access public
     * @param string $type Type of image
     * @param array $data Data of image
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Render for image
     *
     * @access public
     * @param array $codejs Array with JS for Sir Trevor Js
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
     * Converts the image to html
     *
     * @access public
     * @param array $data
     * @return string
     */
    public function imageToHtml()
    {
        if (!isset($this->data['file']['url'])) {
            return null;
        }

        return View::make("sirtrevorjs::image.image", array(
            "url" => $this->data['file']['url'],
            "text" => $this->data['text']
        ));
    }

    /**
     * Converts GettyImage to html
     *
     * @access public
     * @param array $data
     * @return string
     */
    public function gettyimagesToHtml()
    {
        $config = Config::get("sirtrevorjs::sir-trevor-js");

        return View::make("sirtrevorjs::image.gettyimages", array(
            "remote_id" => $this->data['remote_id'],
            "width" => isset($config['gettyimages.width']) ? (int) $config['gettyimages.width'] : 594,
            "height" => isset($config['gettyimages.height']) ? (int) $config['gettyimages.height'] : 465
        ));
    }

    /**
     * Converts Pinterest to html
     *
     * @access public
     * @param string $provider
     * @param string $remote_id
     * @return string
     */
    public function pinterestToHtml(&$codejs)
    {
        /**
         * Pin
         */
        if ($this->data['provider'] === "pin") {
            $codejs['pin'] = '<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js">'
                .'</script>';

            return View::make("sirtrevorjs::image.pin", array("remote_id" => $this->data['remote_id']));
        }

        return null;
    }
}
