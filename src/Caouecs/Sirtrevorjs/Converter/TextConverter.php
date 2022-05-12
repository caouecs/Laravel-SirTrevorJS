<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\Convertible;

/**
 * Text for Sir Trevor Js.
 */
class TextConverter extends BaseConverter implements Convertible
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
     */
    public function getJsExternal(): array
    {
        return [];
    }

    /**
     * Convert text to markdown.
     */
    public function textToHtml(): string
    {
        return $this->view('text.text', [
            'text' => $this->parser->toHtml($this->data['text']),
        ]);
    }

    /**
     * Convert text to markdown.
     */
    public function markdownToHtml(): string
    {
        return $this->textToHtml();
    }

    /**
     * Convert heading.
     */
    public function headingToHtml(): string
    {
        return $this->view('text.heading', [
            'text' => $this->parser->toHtml($this->data['text']),
        ]);
    }

    /**
     * Converts block quotes to html.
     */
    public function blockquoteToHtml(): string
    {
        // remove the indent thats added by Sir Trevor
        $text = str_replace("\n>", "\n", $this->data['text']);
        $text = ltrim($text, '>');

        return $this->view('text.blockquote', [
            'cite' => $this->data['cite'] ?? '',
            'text' => $this->parser->toHtml($text),
        ]);
    }

    /**
     * Converts quote to html.
     */
    public function quoteToHtml(): string
    {
        return $this->blockquoteToHtml();
    }

    /**
     * Converts list to html.
     */
    public function listToHtml(): string
    {
        return $this->textToHtml();
    }
}
