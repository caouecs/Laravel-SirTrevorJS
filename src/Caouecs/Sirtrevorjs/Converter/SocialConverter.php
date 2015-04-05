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
        "tweet",
        "facebook",
    ];

    /**
     * Tweet.
     *
     * @return string
     */
    public function tweetToHtml()
    {
        return $this->view("social.tweet", [
            "data" => $this->data,
        ]);
    }

    /**
     * Facebook.
     *
     * @param array $codejs Array of js
     *
     * @return string
     */
    public function facebookToHtml(&$codejs)
    {
        $codejs['facebook'] = '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if '
            .'(d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/'
            .'en_GB/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document,\'script\',\'facebook-jssdk\'));'
            .'</script>';

        return $this->view("social.facebook", [
            "data" => $this->data,
        ]);
    }
}
