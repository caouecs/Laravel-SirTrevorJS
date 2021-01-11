<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\Convertible;
use Caouecs\Sirtrevorjs\Contracts\Parsable;
use Caouecs\Sirtrevorjs\Exception\NoProviderRemoteId;

/**
 * Videos for Sir Trevor Js.
 */
class VideoConverter extends BaseConverter implements Convertible
{
    /**
     * Provider name.
     *
     * @var string
     */
    protected $provider = '';

    /**
     * Remote id.
     *
     * @var string
     */
    protected $remoteId = '';

    /**
     * Caption.
     *
     * @var string
     */
    protected $caption = '';

    /**
     * Output.
     *
     * @var string
     */
    protected $output = 'html';

    /**
     * Return array js external.
     */
    public function getJsExternal(): array
    {
        return [
            'html' => [
                'vine' => '<script async src="https://platform.vine.co/static/scripts/embed.js" charset="utf-8">'
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
     * @param Parsable $parser Parser instance
     * @param array    $config Config of Sir Trevor Js
     * @param array    $data   Data of video
     * @param string   $output Type of output (amp, fb, html)
     */
    public function __construct(Parsable $parser, array $config, array $data, string $output = 'html')
    {
        if (! is_array($data) || ! isset($data['data']['source']) || ! isset($data['data']['remote_id'])) {
            throw new NoProviderRemoteId();
        }

        $this->caption = $data['data']['caption'] ?? '';
        $this->config = $config;
        $this->output = $output;
        $this->parser = $parser;
        $this->provider = $data['data']['source'];
        $this->remoteId = $data['data']['remote_id'];
        $this->type = 'video';
        $this->title = $data['data']['title'] ?? '';
    }

    /**
     * Render of video tag.
     */
    public function videoToHtml(): string
    {
        return ! in_array($this->provider, $this->providers) ? ''
            : $this->view(
                'video.'.$this->provider,
                [
                    'remote' => $this->remoteId,
                    'caption' => $this->parser->toHtml($this->caption) ?? '',
                    'title' => $this->title ?? $this->provider,
                ],
                $this->provider
            );
    }
}
