<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Contracts;

/**
 * Parser interface.
 */
interface ParserInterface
{
    /**
     * Render markdown to html.
     *
     * @param string $text
     */
    public function toHtml(string $text): string;
}
