<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Config;
use ParsedownExtra;

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
     * @param string $type Type of block
     * @param array $data Array of data
     */
    public function __construct($type, $data)
    {
        $this->markdown = new ParsedownExtra();

        parent::__construct($type, $data);
    }

    /**
     * Convert text to markdown
     *
     * @access public
     * @return string
     */
    public function textToHtml()
    {
        return $this->view("text.text", array(
            "text" => $this->markdown->text($this->data['text'])
        ));
    }

    /**
     * Convert text to markdown
     * 
     * @access public
     * @return string
     */
    public function markdownToHtml()
    {
        return $this->textToHtml();
    }

    /**
     * Convert heading
     *
     * @access public
     * @return string
     */
    public function headingToHtml()
    {
        return $this->view("text.heading", array(
            "text" => $this->data['text']
        ));
    }

    /**
     * Converts block quotes to html
     *
     * @access public
     * @return string
     */
    public function blockquoteToHtml()
    {
        // remove the indent thats added by Sir Trevor
        return $this->view("text.blockquote", array(
            "cite" => $this->data['cite'],
            "text" => $this->markdown->text(ltrim($this->data['text'], '>'))
        ));
    }

    /**
     * Converts quote to html
     *
     * @access public
     * @return string
     */
    public function quoteToHtml()
    {
        return $this->blockquoteToHtml();
    }
}
