<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

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
                'tweet' => '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>',
            ],
            'amp' => [
                'facebook' => '<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/'
                    .'amp-facebook-0.1.js"></script>',
                'tweet' => '<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/'
                    .'amp-twitter-0.1.js"></script>',
            ],
        ];

        return $js;
    }

    /**
     * Tweet.
     */
    public function tweetToHtml(): string
    {
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
