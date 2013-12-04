<?php namespace Caouecs\Sirtrevorjs;

use \Michelf\Markdown;
use \Exception;

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
            foreach($input['data'] as $block) {

                if (!isset($block['data']))
                    break;

                switch ($block['type']) {
                    // tweets
                    case "tweet":
                        $html .= $this->tweetToHtml($block['data']);
                        break;

                    // heading
                    case "heading":
                        $html .= $this->headingToHtml($block['data']['text']);
                        break;

                    // blockquote
                    case "quote":
                        $html .= $this->blockquoteToHtml($block['data']);
                        break;

                    // video
                    case "video":
                        $html .= $this->movieToHtml($block['data']['source'], $block['data']['remote_id']);
                        break;

                    // image
                    case "image":
                        $html .= $this->imageToHtml($block['data']['file']['url']);
                        break;

                    // default
                    default:
                        if (array_key_exists('text', $block['data'])) {
                            $html .= $this->defaultToHtml($block['data']['text']);
                        }
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
    public function tweetToHtml($data)
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
    public function blockquoteToHtml($data)
    {
        // remove the indent thats added by Sir Trevor
        $text = isset($data['text']) ? ltrim($data['text'], '>') : null;
        $cite = isset($data['cite']) ? $data['cite'] : null;

        if ($text == null) {
            return null;
        }

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
     * @param string $url
     * @return string
     */
    public function imageToHtml($url)
    {
        return '<p class="st-image"><img src="' . $url . '" /></p>';
    }

    /**
     * Converts the video to html
     *
     * @param string $source
     * @param string $remote_id
     * @return string
     */
    public function movieToHtml($source, $remote_id)
    {
        $movie = '<p class="st-movie">';
        /**
         * Youtube
         */
        if ($source == "youtube") {
            $movie .= '<iframe width="580" height="320" src="//www.youtube.com/embed/'.$remote_id.'" frameborder="0" allowfullscreen></iframe>';
        }
        /**
         * Vimeo
         */
        elseif ($source == "vimeo") {
            $movie .= '<iframe src="//player.vimeo.com/video/'.$remote_id.'" width="580" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }
        /**
         * Dailymotion
         */
        elseif ($source == "dailymotion") {
            $movie .= '<iframe frameborder="0" width="560" height="315" src="http://www.dailymotion.com/embed/video/'.$remote_id.'"></iframe>';
        }

        $movie .= '</p>';

        return $movie;
    }
}