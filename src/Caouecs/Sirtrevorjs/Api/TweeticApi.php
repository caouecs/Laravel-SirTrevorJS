<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Api;

/**
 * Common api.
 */
class TweeticApi extends Api
{
    /**
     * API url.
     */
    protected string $api = 'https://www.tweetic.io/api/tweet';

    /**
     * Call API.
     */
    public function call(string $tweet): mixed
    {
        $url = $this->api;

        $params = [
            'url' => $tweet,
            'showLink' => 'true',
            'redirect' => 'true',
        ];

        return $this->callApi($url, $params, true);
    }
}
