<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;
use ParsedownExtra;

/**
 * Text for Sir Trevor Js by Markdown.
 */
class TextConverter extends BaseConverter implements ConverterInterface
{
    /**
     * Markdown.
     *
     * @var Markdown
     */
    protected $markdown;

    /**
     * List of types for text.
     *
     * @var array
     */
    protected $types = [
        'text',
        'markdown',
        'quote',
        'blockquote',
        'heading',
        'list',
    ];

    /**
     * Construct.
     *
     * @param array $config Config of Sir Trevor Js
     * @param array $data   Array of data
     */
    public function __construct($config, $data)
    {
        $this->markdown = new ParsedownExtra();

        parent::__construct($config, $data);
    }

    /**
     * Convert text to markdown.
     *
     * @return string
     */
    public function textToHtml()
    {
        return $this->view('text.text', [
            'text' => $this->markdown->text($this->data['text']),
        ]);
    }

    /**
     * Convert text to markdown.
     *
     * @return string
     */
    public function markdownToHtml()
    {
        return $this->textToHtml();
    }

    /**
     * Convert heading.
     *
     * @return string
     */
    public function headingToHtml()
    {
        return $this->view('text.heading', [
            'text' => $this->markdown->text($this->data['text']),
        ]);
    }

    /**
     * Converts block quotes to html.
     *
     * @return string
     */
    public function blockquoteToHtml()
    {
        // remove the indent thats added by Sir Trevor
        return $this->view('text.blockquote', [
            'cite' => $this->data['cite'],
            'text' => $this->markdown->text(ltrim($this->data['text'], '>')),
        ]);
    }

    /**
     * Converts quote to html.
     *
     * @return string
     */
    public function quoteToHtml()
    {
        return $this->blockquoteToHtml();
    }

    /**
     * Converts list to html.
     *
     * @return string
     */
    public function listToHtml()
    {
        return $this->textToHtml();
    }
}
