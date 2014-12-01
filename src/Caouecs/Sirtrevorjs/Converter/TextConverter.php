<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Config;

/**
 * Text for Sir Trevor Js by Markdown
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class TextConverter extends BaseConverter
{
    /**
     * Markdown
     *
     * @access protected
     * @var Markdown
     */
    protected $markdown;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct($markdown)
    {
        $this->markdown = $markdown;

        $this->config = Config::get("sirtrevorjs::sir-trevor-js");
    }

    /**
     * Convert text to markdown
     *
     * @access public
     * @param string $text
     * @return string
     */
    public function defaultToHtml($text)
    {
        return $this->view("text.text", array(
            "text" => $this->markdown->text($text)
        ));
    }

    /**
     * Convert heading
     *
     * @access public
     * @param string $text
     * @return string
     */
    public function headingToHtml($text)
    {
        return $this->view("text.heading", array(
            "text" => $text
        ));
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
        return $this->view("text.blockquote", array(
            "cite" => $cite,
            "text" => $this->markdown->text(ltrim($text, '>'))
        ));
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
}
