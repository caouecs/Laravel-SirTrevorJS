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

                // check if we have a converter for this type
                $converter = $block['type'] . 'ToHtml';
                if (is_callable(array($this, $converter))) {
                    // call the function and add the data as parameters
                    $html .= call_user_func_array(
                        array($this, $converter),
                        $block['data']
                    );
                } elseif ($block['type'] === "tweet") {
                    // special twitter
                    $html .= $this->twitterToHtml($block['data']);
                } elseif (array_key_exists('text', $block['data'])) {
                    // we have a text block. Let's just try the default converter
                    $html .= $this->defaultToHtml($block['data']['text']);
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
     * Converts default elements to html
     *
     * @access public
     * @param string $text
     * @return string
     */
    public function defaultToHtml($text)
    {
        $parsedown = new ParsedownExtra();

        return $parsedown->text($text);
    }

    /**
     * Converts tweet to html
     *
     * @access public
     * @param array $data
     * @return string
     */
    public function twitterToHtml($data)
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
     * Converts headers to html
     *
     * @access public
     * @param string $text
     * @return string
     */
    public function headingToHtml($text)
    {
        return '<h2>' . $text . '</h2>';
    }

    /**
     * Converts block quotes to html
     *
     * @access public
     * @param string $cite
     * @param string $text
     * @return string
     */
    public function blockquoteToHtml($cite, $text)
    {
        // remove the indent thats added by Sir Trevor
        $parsedown = new ParsedownExtra();
        $html = '<blockquote>'.$parsedown->text(ltrim($text, '>'));

        // Add the cite if necessary
        if (!empty($cite)) {
            $html .= '<cite>' . $cite . '</cite>';
        }

        $html .= '</blockquote>';

        return $html;
    }

    /**
     * Converts quote to html
     *
     * @access public
     * @param string $cite
     * @param string $text
     * @return string
     */
    public function quoteToHtml($cite, $text)
    {
        return $this->blockquoteToHtml($cite, $text);
    }

    /**
     * Converts the image to html
     *
     * @access public
     * @param array $file
     * @param string $caption
     * @return string
     */
    public function imageToHtml($file, $caption = '')
    {
        if (!isset($file['url'])) {
            return null;
        }

        $_return = '<figure class="st-image"><img src="' . $file['url'] . '" alt="" />';

        if (!empty($caption)) {
            $_return .= '<figcaption>'.$caption.'</figcaption>';
        }

        $_return .= '</figure>';

        return $_return;
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
     * Converts GettyImage to html
     *
     * @access public
     * @param string $remote_id
     * @return string
     */
    public function gettyimagesToHtml($remote_id)
    {
        return '<p class="st-gettyimages"><iframe src="//embed.gettyimages.com/embed/'.$remote_id.'" width="594" '
            .'height="465" frameborder="0" scrolling="no"></iframe></p>';
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
    public function soundcloud($remote_id)
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
     * Converts Pinterest to html
     *
     * @access public
     * @param string $provider
     * @param string $remote_id
     * @return string
     */
    public function pinterestToHtml($provider, $remote_id)
    {
        $html = null;

        /**
         * Pin
         */
        if ($provider === "pin") {
            $html = '<p class="st-pinterest"><a data-pin-do="embedPin" href="http://pinterest.com/pin/'.$remote_id
                .'/">Pin on Pinterest</a></p>';

            $this->codejs['pin'] = '<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js">'
                .'</script>';
        }

        return $html;
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

    /**
     * Converts the video to html
     *
     * @param string $provider
     * @param string $remote_id
     * @param string $caption
     * @return string
     */
    public function videoToHtml($provider, $remote_id, $caption = null)
    {
        $html = null;

        switch ($provider) {
            /**
             * Youtube
             */
            case "youtube":
                $html = '<iframe width="580" height="320" src="//www.youtube.com/embed/'.$remote_id.'" frameborder="0" '
                    .'allowfullscreen></iframe>';
                break;
            /**
             * Vimeo
             */
            case "vimeo":
                $html = '<iframe src="//player.vimeo.com/video/'.$remote_id.'?title=0&amp;byline=0" width="580" '
                    .'height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                break;
            /**
             * Dailymotion
             */
            case "dailymotion":
                $html = '<iframe frameborder="0" width="580" height="320" src="//www.dailymotion.com/embed/video/'
                    .$remote_id.'"></iframe>';
                break;
            /**
             * Vine
             */
            case "vine":
                $this->codejs['vine'] = '<script async src="http://platform.vine.co/static/scripts/embed.js" '
                    .'charset="utf-8"></script>';

                $html = '<iframe class="vine-embed" src="//vine.co/v/'.$remote_id.'/embed/simple" width="580" '
                    .'height="320" frameborder="0"></iframe>';
                break;
            /**
             * Metacafe
             */
            case "metacafe":
                $html = '<iframe src="http://www.metacafe.com/embed/'.$remote_id.'/" width="540" height="304" '
                    .'allowFullScreen frameborder=0></iframe>';
                break;
            /**
             * Yahoo video
             */
            case "yahoo":
                $html = '<iframe width="640" height="360" scrolling="no" frameborder="0" '
                    .'src="http://screen.yahoo.com/embed/'.$remote_id.'.html" allowfullscreen="true" '
                    .'mozallowfullscreen="true" webkitallowfullscreen="true" allowtransparency="true"></iframe>';
                break;
            /**
             * UStream Live
             */
            case "ustream":
                $html = '<iframe width="640" height="392" src="http://www.ustream.tv/embed/'.$remote_id
                    .'?v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0px none transparent;">'
                    .'</iframe>';
                break;
            /**
             * UStream Recorded
             */
            case "ustreamrecord":
                $html = '<iframe width="640" height="392" src="http://www.ustream.tv/embed/recorded/'.$remote_id
                    .'?v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0px none transparent;">'
                    .'</iframe>';
                break;
            /**
             * Veoh
             */
            case "veoh":
                $html = '<object width="640" height="532" id="veohFlashPlayer" name="veohFlashPlayer">'
                    .'<param name="movie" value="http://www.veoh.com/swf/webplayer/WebPlayer.swf?'
                    .'version=AFrontend.5.7.0.1444&amp;permalinkId='.$remote_id
                    .'&amp;player=videodetailsembedded&amp;videoAutoPlay=0&amp;id=anonymous"></param>'
                    .'<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" '
                    .'value="always"></param><embed src="http://www.veoh.com/swf/webplayer/WebPlayer.swf'
                    .'?version=AFrontend.5.7.0.1444&amp;permalinkId='.$remote_id
                    .'&amp;player=videodetailsembedded&amp;videoAutoPlay=0&amp;id=anonymous" '
                    .'type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" '
                    .'width="640" height="532" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed></object>';
                break;
            /**
             * Vevo
             */
            case "vevo":
                $html = '<iframe width="575" height="324" src="http://cache.vevo.com/m/html/embed.html?video='
                    .$remote_id.'" frameborder="0" allowfullscreen></iframe>';
                break;
            /**
             * AOL
             */
            case "aol":
                $html = '<script type="text/javascript" src="http://pshared.5min.com/Scripts/PlayerSeed.js?sid=281'
                    .'&amp;width=560&amp;height=345&amp;playList='.$remote_id.'"></script>';
                break;
            /**
             * Metatube
             */
            case "metatube":
                $html = '<iframe width="640" height="480" src="http://www.metatube.com/en/videos/'.$remote_id.'/embed/"'
                    .' frameborder="0" allowfullscreen></iframe>';
                break;
            /**
             * Wat.tv
             */
            case "wat":
                $html = '<iframe src="http://www.wat.tv/embedframe/'.$remote_id.'\" frameborder="0" '
                    .'style="width: 640px; height: 360px;"></iframe>';
                break;
            /**
             * Daily Mail UK
             */
            case "dailymailuk":
                $html = '<iframe frameborder="0" width="698" height="503" scrolling="no" id="molvideoplayer" '
                    .'title="MailOnline Embed Player" src="http://www.dailymail.co.uk/embed/video/'.$remote_id
                    .'.html" ></iframe>';
                break;
            /**
             * Canal Plus
             */
            case "cplus":
                $html = '<iframe width="640" height="360" frameborder="0" scrolling="no" '
                    .'src="http://player.canalplus.fr/embed/?param=cplus&amp;vid='.$remote_id.'"></iframe>';
                break;
            /**
             * France Television
             */
            case "francetv":
                $html = '<iframe frameborder="0" width="640" height="360" src="http://api.dmcloud.net/player/embed/'
                    .$remote_id.'?exported=1"></iframe>';
                break;
            /**
             * Zoomin.tv
             */
            case "zoomin":
                $html = '<iframe src="http://blackbird.zoomin.tv/players/.pla?pid=corporatefr&amp;id='.$remote_id
                    .'&amp;w=655&amp;h=433" style="width:655px; height:433px; border:none; overflow:hidden;" '
                    .'frameborder="0" scrolling="no" allowtransparency="yes"></iframe>';
                break;
            /**
             * Global News
             */
            case "globalnews":
                $html = '<iframe src="http://globalnews.ca/video/embed/'.$remote_id.'/" width="670" height="437" '
                    .'frameborder="0" allowfullscreen></iframe>';
                break;
            /**
             * NHL
             */
            case "nhl":
                $html = '<iframe src="http://video.nhl.com/videocenter/embed?playlist='.$remote_id.'" '
                    .'frameborder="0" width="640" height="395"></iframe>';
                break;
            /**
             * Livestream
             */
            case "livestream":
                $html = '<iframe src="http://new.livestream.com/accounts/'.$remote_id.'/player?autoPlay=false&amp;'
                    .'height=360&amp;mute=false&amp;width=640" width="640" height="360" frameborder="0" scrolling="no">'
                    .'</iframe>';
                break;
            /**
             * Ooyala
             */
            case "ooyala":
                $html = '<script height="349px" width="620px" src="http://player.ooyala.com/iframe.js#pbid='.$remote_id
                    .'"></script>';
                break;
            /**
             * NBC Bay Area
             */
            case "nbcbayarea":
                $html = '<script type="text/javascript" charset="UTF-8" src="http://www.nbcbayarea.com/portableplayer/'
                    .'?cmsID='.$remote_id.'&origin=nbcbayarea.com&sec=news&subsec=sports&width=600&height=360">'
                    .'</script>';
                break;
        }

        if (!empty($html)) {
            /**
             * Caption
             */
            if (!empty($caption)) {
                $html .= '<figcaption>'.$caption.'</figcaption>';
            }

            return '<figure class="st-movie">'.$html.'</figure>';
        }

        return null;
    }
}
