<?php namespace Caouecs\Sirtrevorjs;

use \Michelf\MarkdownExtra as Markdown;

/**
 * Class Converter
 *
 * A Sir Trevor to HTML conversion helper for PHP
 * inspired by work of Wouter Sioen <info@woutersioen.be>
 */
class SirTrevorJsConverter
{
    /**
     * Converts the outputted json from Sir Trevor to html
     *
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
                if (!isset($block['data']))
                    break;

                // check if we have a converter for this type
                $converter = $block['type'] . 'ToHtml';
                if (is_callable(array(__CLASS__, $converter))) {
                    // call the function and add the data as parameters
                    $html .= call_user_func_array(
                        array(__CLASS__, $converter),
                        $block['data']
                    );
                } elseif ($block['type'] == "tweet") {
                    // special twitter
                    $html .= $this->twitterToHtml($block['data']);
                } elseif (array_key_exists('text', $block['data'])) {
                    // we have a text block. Let's just try the default converter
                    $html .= $this->defaultToHtml($block['data']['text']);
                }
            }
        }

        return $html;
    }

    /**
     * Converts default elements to html
     *
     * @param string $text
     * @return string
     */
    public function defaultToHtml($text)
    {
        return Markdown::defaultTransform($text);
    }

    /**
     * Converts tweet to html
     *
     * @param array $data
     * @return string
     */
    public function twitterToHtml($data)
    {
        return '<blockquote class="twitter-tweet tw-align-center">
            <p>'.$data['text'].'</p>
            &mdash; '.$data['user']['name'].' (@'.$data['user']['screen_name'].')
            <a href="'.$data['status_url'].'" data-datetime="'.$data['created_at'].'">'.$data['created_at'].'</a>
        </blockquote>
        <script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
    }

    /**
     * Converts headers to html
     *
     * @param string $text
     * @return string
     */
    public function headingToHtml($text)
    {
        return '<h2>' . $text . '</h2>';
    }

    /**
     * Converts quotes to html
     *
     * @param string $cite
     * @param string $text
     * @return string
     */
    public function blockquoteToHtml($cite, $text)
    {
        // remove the indent thats added by Sir Trevor
        $text = ltrim($text, '>');

        $html = '<blockquote>';

        $html .= Markdown::defaultTransform($text);

        // Add the cite if necessary
        if (!empty($cite)) {
            $html .= '<cite>' . $cite . '</cite>';
        }

        $html .= '</blockquote>';
        return $html;
    }

    /**
     * Converts the image to html
     *
     * @param array $file
     * @return string
     */
    public function imageToHtml($file)
    {
        return '<p class="st-image"><img src="' . $file['url'] . '" alt="" /></p>';
    }

    /**
     * Converts Facebook to html
     *
     * @param string $author
     * @param string $remote_id
     * @return string
     */
    public function facebookToHtml($author, $remote_id)
    {
        return '<p class="st-facebook"><div id="fb-root"></div> <script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));</script><div class="fb-post" data-href="https://www.facebook.com/'.$author.'/posts/'.$remote_id.'" data-width="466" style="overflow-x: hidden;overflow-y:hidden; max-width: 100%;"><div class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/'.$author.'/posts/'.$remote_id.'">Post</a> by <a href="https://www.facebook.com/'.$author.'">'.$author.'</a>.</div></div></p>';
    }

    /**
     * Converts the GettyImages to html
     *
     * @param string $remote_id
     * @return string
     */
    public function gettyimagesToHtml($remote_id)
    {
        return '<p class="st-gettyimages"><iframe src="//embed.gettyimages.com/embed/'.$remote_id.'" width="594" height="465" frameborder="0" scrolling="no"></iframe></p>';
    }

    /**
     * Converts Slideshare to html
     *
     * @param string $remote_id
     * @return string
     */
    public function slideshareToHtml($remote_id)
    {
        return '<p class="st-slideshare"><iframe src="http://www.slideshare.net/slideshow/embed_code/'.$remote_id.'?rel=0" width="425" height="355" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC; border-width:1px 1px 0; margin-bottom:5px; max-width: 100%;" allowfullscreen> </iframe></p>';
    }

    /**
     * Converts the video to html
     *
     * @param string $provider
     * @param string $remote_id
     * @return string
     */
    public function videoToHtml($provider, $remote_id)
    {
        $html = '<p class="st-movie">';
        /**
         * Youtube
         */
        if ($provider == "youtube") {
            $html .= '<iframe width="580" height="320" src="//www.youtube.com/embed/'.$remote_id.'" frameborder="0" allowfullscreen></iframe>';
        }
        /**
         * Vimeo
         */
        elseif ($provider == "vimeo") {
            $html .= '<iframe src="//player.vimeo.com/video/'.$remote_id.'?title=0&amp;byline=0" width="580" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }
        /**
         * Dailymotion
         */
        elseif ($provider == "dailymotion") {
            $html .= '<iframe frameborder="0" width="580" height="320" src="//www.dailymotion.com/embed/video/'.$remote_id.'"></iframe>';
        }
        /**
         * Vine
         */
        elseif ($provider == "vine") {
            $html .= '<iframe class="vine-embed" src="//vine.co/v/'.$remote_id.'/embed/simple" width="580" height="320" frameborder="0"></iframe><script async src="http://platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>';
        }

        $html .= '</p>';

        return $html;
    }
}
