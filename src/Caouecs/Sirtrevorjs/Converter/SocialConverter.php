<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

/**
 * Social Network for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class SocialConverter extends BaseConverter
{
    /**
     * List of types for social network
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "tweet", "facebook"
    );

    /**
     * Tweet
     *
     * @access public
     * @return string
     */
    public function tweetToHtml()
    {
        return $this->view("social.tweet", array(
            "data" => $this->data
        ));
    }

    /**
     * Facebook
     *
     * @access public
     * @param array $codejs Array of js
     * @return string
     */
    public function facebookToHtml(&$codejs)
    {
        $codejs['facebook'] = '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if '
            .'(d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/'
            .'en_GB/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document,\'script\',\'facebook-jssdk\'));'
            .'</script>';

        return $this->view("social.facebook", array(
            "data" => $this->data
        ));
    }
}
