<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Parser;

use Caouecs\Sirtrevorjs\Contracts\Parsable;
use Illuminate\Support\Str;

/**
 * Parser by Laravel Str.
 */
class LaravelParser implements Parsable
{
    /**
     * Convert to Html.
     */
    public function toHtml(string $text): string
    {
        return strval(Str::of($text)->markdown());
    }

    /**
     * Transformer.
     */
    public function transformer(string $text = ''): string
    {
        return $text;
    }
}
