<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Contracts;

/**
 * Parser interface.
 */
interface Parsable
{
    /**
     * Render markdown to html.
     */
    public function toHtml(string $text): string;
}
