<?php
/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;
use Exception;

/**
 * Videos for Sir Trevor Js.
 */
class VideoConverter extends BaseConverter implements ConverterInterface
{
    /**
     * Provider name.
     *
     * @var string
     */
    protected $provider = null;

    /**
     * Remote id.
     *
     * @var string
     */
    protected $remote_id = null;

    /**
     * Caption.
     *
     * @var string
     */
    protected $caption = null;

    /**
     * Javascript.
     *
     * @var array
     */
    protected $codejs = [
        "vine" => '<script async src="http://platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>',
    ];

    /**
     * List of types for video.
     *
     * @var array
     */
    protected $types = [
        "video",
    ];

    /**
     * Providers with code.
     *
     * @var array
     */
    protected $providers = [
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
        "zoomin",
    ];

    /**
     * Construct.
     *
     * @param array $config Config of Sir Trevor Js
     * @param array $data   Data of video
     */
    public function __construct($config, $data)
    {
        if (!is_array($data) || !isset($data['data']['source']) || !isset($data['data']['remote_id'])) {
            throw new Exception("Need an array with provider and remote_id", 1);
        }

        $this->type = "video";
        $this->provider = $data['data']['source'];
        $this->remote_id = $data['data']['remote_id'];
        $this->caption = array_get($data['data'], 'caption');
        $this->config = $config;
    }

    /**
     * Render of video tag.
     *
     * @param array $codejs Array of Js
     *
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
            return $this->view("video.".$this->provider, [
                "remote" => $this->remote_id,
                "caption" => $this->caption,
            ]);
        }

        return;
    }
}
