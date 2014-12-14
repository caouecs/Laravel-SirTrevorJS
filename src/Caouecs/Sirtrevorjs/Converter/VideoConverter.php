<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;
use Exception;
use Config;

/**
 * Videos for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class VideoConverter extends BaseConverter implements ConverterInterface
{
    /**
     * Provider name
     *
     * @access protected
     * @var string
     */
    protected $provider = null;

    /**
     * Remote id
     *
     * @access protected
     * @var string
     */
    protected $remote_id = null;

    /**
     * Caption
     *
     * @access protected
     * @var string
     */
    protected $caption = null;

    /**
     * Javascript
     *
     * @access protected
     * @var array
     */
    protected $codejs = array(
        "vine" => '<script async src="http://platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>'
    );

    /**
     * List of types for video
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "video"
    );

    /**
     * Providers with code
     *
     * @access protected
     * @var array
     */
    protected $providers = array(
        "aol",
        "cplus",
        "dailymailuk",
        "dailymotion",
        "francetv",
        "globalnews",
        "livestream",
        "metacafe",
        "metatube",
        "nbcbayarea",
        "nhl",
        "ooyala",
        "redtube",
        "ustream",
        "ustreamrecord",
        "veoh",
        "vevo",
        "vimeo",
        "vine",
        "wat",
        "yahoo",
        "youtube",
        "zoomin"
    );

    /**
     * Construct
     *
     * @access public
     * @param array $data Data of video
     */
    public function __construct($data)
    {
        if (!is_array($data) || !isset($data['source']) || !isset($data['remote_id'])) {
            throw new Exception("Need an array with provider and remote_id", 1);
        }

        $this->type = "video";
        $this->provider = $data['source'];
        $this->remote_id = $data['remote_id'];
        $this->caption = array_get($data, 'caption');
        $this->config = Config::get("sirtrevorjs::sir-trevor-js");
    }

    /**
     * Render of video tag
     *
     * @access public
     * @param array $codejs Array of Js
     * @return string
     */
    public function videoToHtml(&$codejs)
    {
        if (in_array($this->provider, $this->providers)) {
            // JS Code
            if (isset($this->codejs[$this->provider])) {
                $codejs[$this->provider] = $this->codejs[$this->provider];
            }

            // View
            return $this->view("video.".$this->provider, array(
                "remote" => $this->remote_id,
                "caption" => $this->caption
            ));
        }

        return null;
    }
}
