<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs;

use Config;
use ParsedownExtra;

/**
 * Class Converter
 *
 * A Sir Trevor to HTML conversion helper for PHP
 * inspired by work of Wouter Sioen <info@woutersioen.be>
 *
 * @package Caouecs\Sirtrevorjs
 */
class SirTrevorJsConverter
{
    /**
     * Code JS needed by elements
     *
     * @access protected
     * @var array
     */
    protected $codejs = null;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {
        $this->config = Config::get("sirtrevorjs::sir-trevor-js");
    }

    /**
     * Converts the outputted json from Sir Trevor to html
     *
     * @access public
     * @param string $json
     * @return string
     */
    public function toHtml($json)
    {
        // convert the json to an associative array
        $input = json_decode($json, true);
        $html  = null;

        if (!empty($input) && is_array($input)) {
            // loop trough the data blocks
            foreach ($input['data'] as $block) {
                // no data, problem
                if (!isset($block['data'])) {
                    break;
                }

                // Block Video
                if ($block['type'] === "video") {
                    $converter = new Converter\VideoConverter($block['data']);
                    $converter->jscode($this->codejs);

                    $html .= $converter->render();
                // Blocks Image or Service for Images
                } elseif (in_array($block['type'], array("image", "gettyimages", "pinterest"))) {
                    $converter = new Converter\ImageConverter($block['type'], $block['data']);

                    $html .= $converter->render($this->codejs);
                } else {
                    $converter = $block['type'] . 'ToHtml';
                    if (is_callable(array($this, $converter))) {
                        // call the function and add the data as parameters
                        $html .= call_user_func_array(
                            array($this, $converter),
                            $block['data']
                        );
                    } else {
                        // Text converter
                        $textConverter = new Converter\TextConverter();

                        if (is_callable(array($textConverter, $converter))) {
                            $html .= call_user_func_array(
                                array($textConverter, $converter),
                                $block['data']
                            );
                        } elseif (array_key_exists('text', $block['data'])) {
                            // we have a text block. Let's just try the default converter
                            $html .= $textConverter->defaultToHtml($block['data']['text']);
                        }
                    }
                }
            }

            // code js
            if (!empty($this->codejs) && is_array($this->codejs)) {
                foreach ($this->codejs as $arr) {
                    $html .= $arr;
                }
            }
        }

        return $html;
    }
    /**
     * Converts tweet to html
     *
     * @access public
     * @param array $data
     * @return string
     */
    public function tweetToHtml($data)
    {
        $this->codejs['twitter'] = '<script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';

        return '<blockquote class="twitter-tweet tw-align-center">
            <p>'.$data['text'].'</p>
            &mdash; '.$data['user']['name'].' (@'.$data['user']['screen_name'].')
            <a href="'.$data['status_url'].'" data-datetime="'.$data['created_at'].'">'.$data['created_at'].'</a>
        </blockquote>';
    }

    /**
     * Converts Embedly card to html
     *
     * @access public
     * @param string $url
     * @return string
     */
    public function embedlycardToHtml($url)
    {
        $this->codejs['embedly_card'] = '<script>(function(a){var b="embedly-platform",c="script";'
            .'if(!a.getElementById(b)){var d=a.createElement(c);d.id=b;d.async=true;d.src=("https:"===document.location'
            .'protocol?"https":"http")+"://cdn.embedly.com/widgets/platform.js";var e=document.getElementsByTagName(c)'
            .'[0];e.parentNode.insertBefore(d,e)}})(document);</script>';

        return '<a class="embedly-card" href="'.$url.'">&nbsp;</a>';
    }

    /**
     * Converts Facebook to html
     *
     * @access public
     * @param string $author
     * @param string $remote_id
     * @return string
     */
    public function facebookToHtml($author, $remote_id)
    {
        $this->codejs['facebook'] = '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if '
            .'(d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/'
            .'en_GB/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'))'
            .';</script>';

        return '<p class="st-facebook"><div id="fb-root"></div> <div class="fb-post" data-href="https://www.facebook.'
            .'com/'.$author.'/posts/'.$remote_id.'" data-width="466" style="overflow-x: hidden;overflow-y:hidden; '
            .'max-width: 100%;"><div class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/'.$author.'/posts/'
            .$remote_id.'">Post</a> by <a href="https://www.facebook.com/'.$author.'">'.$author.'</a>.</div></div></p>';
    }

    /**
     * Converts Spotify track to html
     *
     * @access public
     * @param string $remote_id
     * @return string
     */
    public function spotifyToHtml($remote_id)
    {
        return '<iframe src="https://embed.spotify.com/?uri=spotify:track:'.$remote_id.'" width="300" height="380" '
            .'frameborder="0" allowtransparency="true"></iframe>';
    }

    /**
     * Converts Slideshare to html
     *
     * @access public
     * @param string $remote_id
     * @return string
     */
    public function slideshareToHtml($remote_id)
    {
        return '<p class="st-slideshare"><iframe src="http://www.slideshare.net/slideshow/embed_code/'.$remote_id
            .'?rel=0" width="425" height="355" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" '
            .'style="border:1px solid #CCC; border-width:1px 1px 0; margin-bottom:5px; max-width: 100%;" '
            .'allowfullscreen> </iframe></p>';
    }

    /**
     * Converts Issuu to html
     *
     * @access public
     * @param string $remote_id
     * @return string
     */
    public function issuuToHtml($remote_id)
    {
        $this->codejs['issuu'] = '<script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>';

        return '<p class="issuu"><div data-configid="'.$remote_id.'" style="width: 600px; height: 480px;" '
            .'class="issuuembed"></div>';
    }

    /**
     * Converts SoundCloud player
     * you can define the type of player in config file
     *
     * @access public
     * @param string $remote_id
     * @return string
     */
    public function soundcloudToHtml($remote_id)
    {
        if (isset($config['soundcloud']) && $config['soundcloud'] === "full") {
            return '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com'
                .'/player/?url=https%3A//api.soundcloud.com/tracks/'.$remote_id.'&amp;auto_play=false&amp;'
                .'hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"'
                .'></iframe>';
        }

        return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/'
            .'?url=https%3A//api.soundcloud.com/tracks/'.$remote_id.'&amp;auto_play=false&amp;hide_related=false'
            .'&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;color=ff5500"></iframe>';
    }

    /**
     * Converts Sketchlab to html
     *
     * @param string $remote_id
     * @return string
     */
    public function sketchlabToHtml($remote_id)
    {
        return '<p class="st-sketchlab"><iframe allowFullScreen webkitallowfullscreen mozallowfullscreen '
            .'src="https://sketchfab.com/models/'.$remote_id.'/embed" width="640\ height="480" frameborder="0" '
            .'scrolling="no"></iframe></p>';
    }
}
