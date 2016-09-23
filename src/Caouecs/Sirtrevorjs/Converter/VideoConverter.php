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
    protected $remoteId = null;

    /**
     * Caption.
     *
     * @var string
     */
    protected $caption = null;

    /**
     * Output.
     *
     * @var string
     */
    protected $output = 'html';

    /**
     * Return array js external.
     *
     * @return array
     */
    public function getJsExternal()
    {
        return [
            'html' => [
                'vine' => '<script async src="http://platform.vine.co/static/scripts/embed.js" charset="utf-8">'
                    .'</script>',
            ],
            'amp' => [
                'dailymotion' => '<script async custom-element="amp-dailymotion" src="https://cdn.ampproject.org/'
                    .'v0/amp-dailymotion-0.1.js"></script>',
                'vimeo' => '<script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/'
                    .'amp-vimeo-0.1.js"></script>',
                'vine' => '<script async custom-element="amp-vine" src="https://cdn.ampproject.org/v0/'
                    .'wamp-vine-0.1.js"></script>',
                'youtube' => '<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/'
                    .'amp-youtube-0.1.js"></script>',
            ],
        ];
    }

    /**
     * List of types for video.
     *
     * @var array
     */
    protected $types = [
        'video',
    ];

    /**
     * Providers with code.
     *
     * @var array
     */
    protected $providers = [
        'aol',
        'cplus',
        'dailymailuk',
        'dailymotion',
        'francetv',
        'globalnews',
        'livestream',
        'metacafe',
        'metatube',
        'mlb',
        'nbcbayarea',
        'nhl',
        'ooyala',
        'redtube',
        'ustream',
        'ustreamrecord',
        'veoh',
        'vevo',
        'vimeo',
        'vine',
        'wat',
        'yahoo',
        'youtube',
        'zoomin',
    ];

    /**
     * Construct.
     *
     * @param mixed $parser Parser instance
     * @param array $config Config of Sir Trevor Js
     * @param array $data   Data of video
     * @param string $output Type of output (amp, fb, html)
     */
    public function __construct($parser, $config, $data, $output = 'html')
    {
        if (!is_array($data) || !isset($data['data']['source']) || !isset($data['data']['remote_id'])) {
            throw new Exception('Need an array with provider and remote_id', 1);
        }

        $this->type = 'video';
        $this->provider = $data['data']['source'];
        $this->remoteId = $data['data']['remote_id'];
        $this->caption = array_get($data['data'], 'caption');
        $this->config = $config;
        $this->parser = $parser;
        $this->output = $output;
    }

    /**
     * Render of video tag.
     *
     * @return string
     */
    public function videoToHtml()
    {
        if (in_array($this->provider, $this->providers)) {
            $caption = null;
            if (!empty($this->caption)) {
                $caption = $this->parser->toHtml($this->caption);
            }

            // View
            return $this->view(
                'video.'.$this->provider,
                [
                    'remote' => $this->remoteId,
                    'caption' => $caption,
                ],
                $this->provider
            );
        }

        return '';
    }
}
