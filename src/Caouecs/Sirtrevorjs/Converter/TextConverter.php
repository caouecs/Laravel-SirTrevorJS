<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

use ParsedownExtra;
use View;

/**
 * Text for Sir Trevor Js by Markdown
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class TextConverter extends ParsedownExtra
{
    /**
     * Convert text to markdown
     *
     * @access public
     * @param string $text
     * @return string
     */
    public function defaultToHtml($text)
    {
        return $this->text($text);
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
        return View::make("sirtrevorjs::quote", array(
            "cite" => $cite,
            "text" => $this->text(ltrim($text, '>'))
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
