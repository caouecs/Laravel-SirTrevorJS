<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Exception;

use Exception;

/**
 * Exception for videos without provider or remote id.
 */
class NoProviderRemoteId extends Exception
{
    /**
     * Construct.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct()
    {
        parent::__construct('Need an array with provider and remote_id', 1);
    }
}
