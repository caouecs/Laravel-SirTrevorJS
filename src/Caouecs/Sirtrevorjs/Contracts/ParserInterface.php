<?php

namespace Caouecs\Sirtrevorjs\Contracts;

/**
 * Parser interface.
 */
interface ParserInterface
{
    /**
     * Render markdown to html.
     *
     * @param  string $text
     *
     * @return string
     */
    public function toHtml($text);
}
