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
abstract class Api
{
    /**
     * Call API.
     */
    public function callApi(string $url, array $params = [], bool $outputArray = false): mixed
    {
        $requests = [];

        foreach ($params as $key => $value) {
            $requests[] = $key.'='.urlencode($value);
        }

        if (count($requests) > 0) {
            $url .= '?'.implode('&', $requests);
        }

        $call = curl_init();
        curl_setopt_array(
            $call,
            [
                CURLOPT_URL => $url,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
            ]
        );

        $return = curl_exec($call);

        curl_close($call);

        return $outputArray && is_string($return) ? json_decode($return, true) : $return;
    }
}
