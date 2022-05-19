<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Api\TweeticApi;
use Caouecs\Sirtrevorjs\Contracts\Convertible;

/**
 * Social Network for Sir Trevor Js.
 */
class SocialConverter extends BaseConverter implements Convertible
{
    /**
     * List of types for social network.
     *
     * @var array
     */
    protected $types = [
        'facebook',
        'tweet',
    ];

    /**
     * Return array js external.
     */
    public function getJsExternal(): array
    {
        $js = [
            'html' => [
                'facebook' => '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if ('
                    .'d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.'
                    .'facebook.net/en_GB/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document,'
                    .'\'script\',\'facebook-jssdk\'));</script>',
            ],
            'amp' => [
                'facebook' => '<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/'
                    .'amp-facebook-0.1.js"></script>',
                'tweet' => '<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/'
                    .'amp-twitter-0.1.js"></script>',
            ],
        ];

        if (! $this->config['tweetic']) {
            $js['html']['tweet'] = '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
        }

        return $js;
    }

    /**
     * Tweet with Tweetic API.
     */
    public function tweetToHtml(): string
    {
        if ($this->config['tweetic']) {
            $api = new TweeticApi();
            $data = $api->call($this->data['status_url']);

            if (! empty($data['html'])) {
                return $data['html'];
            }
        }

        return $this->view('social.tweet', [
            'data' => $this->data,
        ]);
    }

    /**
     * Facebook.
     */
    public function facebookToHtml(): string
    {
        return $this->view('social.facebook', [
            'data' => $this->data,
        ]);
    }
}
