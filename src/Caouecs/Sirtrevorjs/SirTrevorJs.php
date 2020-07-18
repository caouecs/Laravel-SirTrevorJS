<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use HTML;

/**
 * Sir Trevor Js.
 */
class SirTrevorJs
{
    /**
     * Textarea class.
     *
     * @var string
     * @static
     */
    protected static $class = 'sir-trevor';

    /**
     * Block types.
     *
     * @var array
     * @static
     */
    protected static $blocktypes = [
        'Text',
        'List',
        'Quote',
        'Image',
        'Video',
        'Tweet',
        'Heading',
    ];

    /**
     * Language of Sir Trevor JS.
     *
     * @var string
     * @static
     */
    protected static $language = 'en';

    /**
     * Upload url for images.
     *
     * @var string
     * @static
     */
    protected static $uploadUrl = '/sirtrevorjs/upload';

    /**
     * Url for tweets.
     *
     * @var string
     * @static
     */
    protected static $tweetUrl = '/sirtrevorjs/tweet';

    /**
     * Transform text with image bug.
     *
     * @param string $text Text to fix
     *
     * @return string|bool
     * @static
     */
    public static function transformText(string $text)
    {
        $text = json_decode($text, true);

        $return = [];

        if (is_array($text) && isset($text['data'])) {
            foreach ($text['data'] as $data) {
                /*
                 * The bug is with new image, the data is in an array where each character is an element of this array
                 *
                 * This code transforms this array into a string (JSON format)
                 * and after it transforms it into an another array for Sir Trevor
                 */
                if ('image' === $data['type'] && ! isset($data['data']['file'])) {
                    $return[] = [
                        'type' => 'image',
                        'data' => json_decode(implode($data['data']), true),
                    ];
                } else {
                    $return[] = $data;
                }
            }

            return json_encode(['data' => $return], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return '';
    }

    /**
     * Stylesheet files
     *   see config file.
     *
     * @static
     */
    public static function stylesheets(): string
    {
        // params in config file
        $config = config('sir-trevor-js');

        /*
         * Files of Sir Trevor JS
         */
        $return = HTML::style($config['path'].'sir-trevor-icons.css')
            .HTML::style($config['path'].'sir-trevor.css');

        /*
         * Others files if you need it
         */
        if (isset($config['stylesheet']) && is_array($config['stylesheet'])) {
            foreach ($config['stylesheet'] as $arr) {
                if (file_exists(public_path($arr))) {
                    $return .= HTML::style($arr);
                }
            }
        }

        return $return;
    }

    /**
     * Javascript files.
     *
     * @param array $params
     *
     * @static
     *
     * Params :
     * - class
     * - blocktypes
     * - language
     * - uploadUrl
     * - tweetUrl
     */
    public static function scripts(array $params = []): string
    {
        // params
        $config = self::config($params);
        $return = '';

        /*
         * Others files
         */
        if (isset($config['script']) && is_array($config['script'])) {
            foreach ($config['script'] as $arr) {
                if (file_exists(public_path($arr))) {
                    $return .= HTML::script($arr);
                }
            }
        }

        /*
         * File of Sir Trevor JS
         */
        $return .= HTML::script($config['path'].'sir-trevor.min.js');

        /*
         * Language
         */
        if ('en' != $config['language']) {
            $return .= HTML::script($config['path'].'locales/'.$config['language'].'.js');
        }

        return $return.view('sirtrevorjs::js', ['config' => $config]);
    }

    /**
     * Configuration of Sir Trevor JS.
     *
     * 1 - $params
     * 2 - config file
     * 3 - default
     *
     * @param array $params Personnalized params
     *
     * @static
     */
    public static function config(array $params = []): array
    {
        // params in config file
        $config = config('sir-trevor-js');

        /*
         * Block types
         */
        $blocktypes = self::$blocktypes;

        // params
        if (isset($params['blocktypes']) && ! empty($params['blocktypes']) && is_array($params['blocktypes'])) {
            $blocktypes = $params['blocktypes'];
        // config
        } elseif (isset($config['blocktypes']) && ! empty($config['blocktypes']) && is_array($config['blocktypes'])) {
            $blocktypes = $config['blocktypes'];
        }

        return [
            'blocktypes' => '\''.implode('\', \'', $blocktypes).'\'',
            'class' => self::defineParam('class', $params),
            'language' => self::defineParam('language', $params, $config),
            'path' => $config['path'],
            'script' => $config['script'],
            'tweetUrl' => self::defineParam('tweetUrl', $params, $config),
            'uploadUrl' => self::defineParam('uploadUrl', $params, $config),
            'version' => $config['version'],
        ];
    }

    /**
     * Define param.
     *
     * @param string $type
     * @param array  $params
     * @param array  $config
     */
    private static function defineParam(string $type, array $params, array $config = []): string
    {
        // params
        if (isset($params[$type]) && ! empty($params[$type])) {
            return $params[$type];
        }

        // config and default
        return isset($config[$type]) && ! empty($config[$type]) ? $config[$type] : self::$$type;
    }

    /**
     * Convert json from Sir Trevor JS to html.
     *
     * @param string $text
     *
     * @static
     */
    public static function render(string $text): string
    {
        return app('caouecs.sirtrevorjs.converter')->toHtml($text);
    }

    /**
     * Find first image in text from Sir Trevor JS.
     *
     * @param string $text
     *
     * @static
     */
    public static function findImage(string $text): string
    {
        $array = json_decode($text, true);

        if (! empty($array['data'])) {
            foreach ($array['data'] as $arr) {
                if ('image' === $arr['type'] && isset($arr['data']['file']['url'])) {
                    return $arr['data']['file']['url'];
                }
            }
        }

        return '';
    }

    /**
     * Find occurences of a type of block in a text.
     *
     * @param string $text
     * @param string $blocktype
     * @param string $output    json or array
     * @param int    $nbr       Number of occurences ( 0 = all )
     *
     * @return array|string|bool Returns list of blocks in an array or a json, if exists. Else, returns false
     * @static
     */
    public static function find(string $text, string $blocktype, string $output = 'json', int $nbr = 0)
    {
        $array = json_decode($text, true);

        if (! isset($array['data'])) {
            return false;
        }

        $return = [];
        $_nbr = 1;

        foreach ($array['data'] as $arr) {
            if ($arr['type'] == $blocktype) {
                $return[] = $arr['data'];

                if ($_nbr == $nbr) {
                    break;
                }

                ++$_nbr;
            }
        }

        return count($return) === 0 || 'array' === $output ? $return
            : json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Find first occurence of a type of block in a text.
     *
     * @param string $text
     * @param string $blocktype
     * @param string $output    json or array
     *
     * @return array|bool|string Returns list of blocks in an array if exists. Else, returns false
     * @static
     */
    public static function first(string $text, string $blocktype, string $output = 'json')
    {
        return self::find($text, $blocktype, $output, 1);
    }
}
