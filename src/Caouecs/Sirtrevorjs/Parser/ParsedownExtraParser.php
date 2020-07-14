<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Parser;

use Caouecs\Sirtrevorjs\Contracts\ParserInterface;
use ParsedownExtra;

/**
 * Parser by ParsedownExtra.
 */
class ParsedownExtraParser extends ParsedownExtra implements ParserInterface
{
    /**
     * Convert to Html.
     *
     * @param string $text
     */
    public function toHtml(string $text): string
    {
        return $this->text($text);
    }
}
