<?php

namespace Caouecs\Sirtrevorjs\Parser;

use Caouecs\Sirtrevorjs\Contracts\ParserInterface;
use ParsedownExtra;

class ParsedownExtraParser extends ParsedownExtra implements ParserInterface
{
    /**
     * Convert to Html.
     *
     * @param string $text
     *
     * @return string
     */
    public function toHtml($text)
    {
        return $this->text($text);
    }
}
