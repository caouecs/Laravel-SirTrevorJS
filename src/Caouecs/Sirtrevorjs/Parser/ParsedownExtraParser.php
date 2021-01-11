<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Parser;

use Caouecs\Sirtrevorjs\Contracts\Parsable;
use ParsedownExtra;

/**
 * Parser by ParsedownExtra.
 */
class ParsedownExtraParser extends ParsedownExtra implements Parsable
{
    /**
     * Convert to Html.
     */
    public function toHtml(string $text): string
    {
        return $this->text($text);
    }
}
