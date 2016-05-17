<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Social Network for Sir Trevor Js.
 */
class SocialConverter extends BaseConverter implements ConverterInterface
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
     *
     * @return array
     */
    public function getJsExternal()
    {
        return [
            'html' => [
                'facebook' => '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if ('
                    .'d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.'
                    .'facebook.net/en_GB/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document,'
                    .'\'script\',\'facebook-jssdk\'));</script>',
            ],
            'amp' => [
                'tweet' => '<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/'
                    .'amp-twitter-0.1.js"></script>',
            ],
        ];
    }

    /**
     * Tweet.
     *
     * @return string
     */
    public function tweetToHtml()
    {
        return $this->view('social.tweet', [
            'data' => $this->data,
        ]);
    }

    /**
     * Facebook.
     *
     * @return string
     */
    public function facebookToHtml()
    {
        return $this->view('social.facebook', [
            'data' => $this->data,
        ]);
    }
}
