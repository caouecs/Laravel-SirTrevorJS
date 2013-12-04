<?php namespace Caouecs\Sirtrevorjs;

use \Config;

class SirTrevorJs {

    /**
     * Textarea class
     *
     * @access protected
     * @var string
     */
    static protected $class = "sir-trevor";

    /**
     * Path of files
     *
     * @access protected
     * @var string
     */
    static protected $path = "/packages/caouecs/sirtrevorjs/0.3.0";

    /**
     * Block types
     *
     * @access protected
     * @var string
     */
    static protected $blocktypes = array('Text', 'List', 'Quote', 'Image', 'Video', 'Tweet', 'Heading');

    /**
     * Transform text with image bug
     *
     * @access public
     * @param string $txt Text to fix
     * @return string
     */
    static public function transformText($txt)
    {
        $txt = json_decode($txt, true);

        $return = null;

        if (is_array($txt) && isset($txt['data'])) {

            foreach ($txt['data'] as $data) {
                /**
                 * The bug is with new image, the data is in an array where each character is an element of this array
                 *
                 * This code transforms this array into a string (JSON format)
                 * and after it transforms it into an another array for Sir Trevor
                 */
                if ($data['type'] == "image" && !isset($data['data']['file'])) {
                    $return[] = array(
                        "type" => "image",
                        "data" => json_decode(implode($data['data']), true)
                    );
                } else {
                    $return[] = $data;
                }
            }
            
            return json_encode(array("data" => $return), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return null;
    }

    /**
     * Stylesheet files
     *
     * @access public
     * @return string
     */
    static public function stylesheets()
    {
        $config = self::config();

        $return  = HTML::style($config['path']."/sir-trevor-icons.css");
        $return .= HTML::style($config['path']."/sir-trevor.css");

        return $return;
    }

    /**
     * Javascript files
     *
     * @access public
     * @param array $params
     * @return string
     *
     * Params :
     * - path
     * - class
     * - blocktypes
     */
    static public function javascripts($params = array())
    {
        $config = self::config($params);

        $return  = HTML::script($config['path']."/underscore-min.1.4.4.js");
        $return .= HTML::script($config['path']."/eventable.js");
        $return .= HTML::script($config['path']."/sir-trevor.min.js");

        $return .= HTML::jscode("
            $(function(){
              window.editor = new SirTrevor.Editor({
                el: $('.".$config['class']."'),
                blockTypes: [
                  ".$config['blocktypes']."
                ]
              });

              SirTrevor.setDefaults({
                uploadUrl: '/sirtrevorjs/upload'
              });

              SirTrevor.setBlockOptions('Tweet', {
                fetchUrl: function(tweetID) {
                    return '/sirtrevorjs/tweet?tweet_id=' + tweetID;
                }
              });

            });");

        return $return;
    }

    /**
     * Configuration of Sir Trevor JS
     *
     * 1 - $params
     * 2 - config file
     * 3 - default
     *
     * @access public
     * @param array $params Personnalized params
     * @return array
     */
    static public function config($params = null)
    {
        // params in config file
        $config = Config::get("sirtrevorjs::sir-trevor-js");

        /**
         * Class or ID of textarea
         */
        // params
        if (isset($params['class']) && !empty($params['class'])) {
            $class = $params['class'];
        // default
        } else {
            $class = self::$class;
        }

        /**
         * Path
         */
        // params
        if (isset($params['path']) && !empty($params['path'])) {
            $path = $params['path'];
        // config
        } elseif (isset($config['path']) && !empty($config['path'])) {
            $path = $config['path'];
        // default
        } else {
            $path = self::$path;
        }

        /**
         * Block types
         */
        // params
        if (isset($params['blocktypes']) && !empty($params['blocktypes']) && is_array($params['blocktypes'])) {
            $blocktypes = $params['blocktypes'];
        // config
        } elseif (isset($config['blocktypes']) && !empty($config['blocktypes']) && is_array($config['blocktypes'])) {
            $blocktypes = $config['blocktypes'];
        // default
        } else {
            $blocktypes = self::$blocktypes;
        }

        $blocktypes = "'".implode("', '", $blocktypes)."'";

        return array(
            "path"       => $path,
            "blocktypes" => $blocktypes,
            "class"      => $class
        );
    }

    /**
     * Convert json from Sir Trevor JS to html
     *
     * @access public
     * @param string $text
     * @return string
     */
    static public function render($text)
    {
        $converter = new SirTrevorJsConverter();

        return $converter->toHtml($text);
    }

    /**
     * Find first image in text from Sir Trevor JS
     *
     * @access public
     * @param string $text
     * @return string Url of image
     */
    static public function findImage($text)
    {
        $array = json_decode($text, true);

        if ($array === false || $array == null || !isset($array['data'])) {
            return null;
        }

        foreach ($array['data'] as $arr) {
            if ($arr['type'] == "image") {
                return $arr['data']['file']['url'];
            }
        }

        return null;        
    }

    /**
     * Find all occurences of a type of block in a text
     *
     * @access public
     * @param string $text
     * @param string $blocktype
     * @param string $output json or array
     * @return array | boolean Returns list of blocks in an array if exists. Else, returns false
     */
    static public function find($text, $blocktype, $output = "json")
    {
        $array = json_decode($text, true);

        if ($array === false || $array == null || !isset($array['data'])) {
            return null;
        }

        $return = null;

        foreach ($array['data'] as $arr) {
            if ($arr['type'] == $blocktype) {
                $return[] = $arr['data'];
            }
        }

        if ($return == null) {
            return false;
        }

        if ($output == "array") {
            return $return;
        }

        return json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
