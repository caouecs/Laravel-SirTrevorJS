<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */
namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Text for Sir Trevor Js.
 */
class TextConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types for text.
     *
     * @var array
     */
    protected $types = [
        'blockquote',
        'heading',
        'list',
        'markdown',
        'quote',
        'text',
    ];

    /**
     * Return array js external.
     *
     * @return array
     */
    public function getJsExternal()
    {
        return [];
    }

    /**
     * Convert text to markdown.
     *
     * @return string
     */
    public function textToHtml()
    {
        return $this->view('text.text', [
            'text' => $this->parser->text($this->data['text']),
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
            'text' => $this->parser->text($this->data['text']),
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
            'text' => $this->parser->text(ltrim($this->data['text'], '>')),
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
