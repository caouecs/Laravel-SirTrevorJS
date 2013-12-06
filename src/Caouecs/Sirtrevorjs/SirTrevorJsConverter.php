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
        return '<blockquote class="twitter-tweet" align="center">
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
     * @param array $data
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
        return '<p class="st-image"><img src="' . $file['url'] . '" /></p>';
    }

    /**
     * Converts the video to html
     *
     * @param array $movie
     * @return string
     */
    public function videoToHtml($source, $remote_id)
    {
        $html = '<p class="st-movie">';
        /**
         * Youtube
         */
        if ($source == "youtube") {
            $html .= '<iframe width="580" height="320" src="//www.youtube.com/embed/'.$remote_id.'" frameborder="0" allowfullscreen></iframe>';
        }
        /**
         * Vimeo
         */
        elseif ($source == "vimeo") {
            $html .= '<iframe src="//player.vimeo.com/video/'.$remote_id.'?title=0&byline=0" width="580" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }
        /**
         * Dailymotion
         */
        elseif ($source == "dailymotion") {
            $html .= '<iframe frameborder="0" width="580" height="320" src="//www.dailymotion.com/embed/video/'.$remote_id.'"></iframe>';
        }
        /**
         * Vine
         */
        elseif ($source == "vine") {
            $html .= '<iframe class="vine-embed" src="//vine.co/v/'.$remote_id.'/embed/simple" width="580" height="320" frameborder="0"></iframe><script async src="http://platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>';
        }

        $html .= '</p>';

        return $html;
    }
}