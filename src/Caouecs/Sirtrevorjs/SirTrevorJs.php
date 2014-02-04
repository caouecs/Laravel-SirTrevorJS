<?php namespace Caouecs\Sirtrevorjs;

use \Config;
use \HTML;

class SirTrevorJs {

    /**
     * Textarea class
     *
     * @access protected
     * @var string
     */
    static protected $class = "sir-trevor";

    /**
     * Block types
     *
     * @access protected
     * @var string
     */
    static protected $blocktypes = array('Text', 'List', 'Quote', 'Image', 'Video', 'Tweet', 'Heading');

    /**
     * Language of Sir Trevor JS
     *
     * @access protected
     * @var string
     */
    static protected $language = "en";

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
     *   see config file
     *
     * @access public
     * @return string
     */
    static public function stylesheets()
    {
        // params in config file
        $config = Config::get("sirtrevorjs::sir-trevor-js");

        /**
         * Files of Sir Trevor JS
         */
        $return = HTML::style($config['path']."/sir-trevor-icons.css");
        $return .= HTML::style($config['path']."/sir-trevor.css");

        /**
         * Others files if you need it
         */
        if (isset($config['stylesheet']) && is_array($config['stylesheet'])) {
            foreach ($config['stylesheet'] as $arr) {
                if (file_exists(public_path($arr)))
                    $return .= HTML::style($arr);
            }
        }

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
     * - class
     * - blocktypes
     * - language
     */
    static public function javascripts($params = array())
    {
        // params
        $config = self::config($params);

        /**
         * File of Sir Trevor JS
         */
        $return = HTML::script($config['path']."/sir-trevor.min.js");

        /**
         * Others files
         */
        if (isset($config['script']) && is_array($config['script'])) {
            foreach ($config['script'] as $arr) {
                if (file_exists(public_path($arr)))
                    $return .= HTML::script($arr);
            }
        }

        if ($config['language'] != "en") {
            $return .= HTML::script($config['path']."/locales/".$config['language'].".js");
        }

        $return .= "<script type=\"text/javascript\">
            $(function(){ ";

        if ($config['language'] != "en") {
            $return .=  " SirTrevor.LANGUAGE = '".$config['language']."'; ";
        }

        $return .= " SirTrevor.setDefaults({
                uploadUrl: '/sirtrevorjs/upload'
              });

              SirTrevor.setBlockOptions('Tweet', {
                fetchUrl: function(tweetID) {
                    return '/sirtrevorjs/tweet?tweet_id=' + tweetID;
                }
              });

              window.editor = new SirTrevor.Editor({
                el: $('.".$config['class']."'),
                blockTypes: [
                  ".$config['blocktypes']."
                ]
              });

            });
            </script>".PHP_EOL;

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

        /**
         * Language
         */
        // params
        if (isset($params['language']) && !empty($params['language'])) {
            $language = $params['language'];
        // config
        } elseif (isset($config['language']) && !empty($config['language'])) {
            $language = $config['language'];
        // default
        } else {
            $language = self::$language;
        }

        return array(
            "path"       => $config['path'],
            "script"     => $config['script'],
            "blocktypes" => $blocktypes,
            "class"      => $class,
            "language"   => e($language)
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
            if ($arr['type'] == "image" && isset($arr['data']['file']['url'])) {
                return $arr['data']['file']['url'];
            }
        }

        return null;
    }

    /**
     * Find occurences of a type of block in a text
     *
     * @access public
     * @param string $text
     * @param string $blocktype
     * @param string $output json or array
     * @param int $nbr Number of occurences ( 0 = all )
     * @return array | boolean Returns list of blocks in an array if exists. Else, returns false
     */
    static public function find($text, $blocktype, $output = "json", $nbr = 0)
    {
        $array = json_decode($text, true);

        if ($array === false || $array == null || !isset($array['data'])) {
            return null;
        }

        $return = null;
        $_nbr = 1;

        foreach ($array['data'] as $arr) {
            if ($arr['type'] == $blocktype) {
                $return[] = $arr['data'];

                if ($nbr > 0 && $_nbr == $nbr) {
                    break;
                }

                $_nbr++;
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

    /**
     * Find first occurence of a type of block in a text
     *
     * @access public
     * @param string $text
     * @param string $blocktype
     * @param string $output json or array
     * @return array | boolean Returns list of blocks in an array if exists. Else, returns false
     */
    static public function first($text, $blocktype, $output = "json")
    {
        return self::find($text, $blocktype, $output, 1);
    }
}
