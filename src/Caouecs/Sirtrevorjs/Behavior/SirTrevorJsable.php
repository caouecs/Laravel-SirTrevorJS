<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Behavior;

use Atymic\Twitter\Facade\Twitter;
use Illuminate\Http\Request;

/**
 * Trait Controller Sir Trevor Js
 * - upload image
 * - display tweet.
 */
trait SirTrevorJsable
{
    /**
     * Upload image.
     *
     * @internal you can define `directory_upload` in config file
     */
    public function upload(Request $request): void
    {
        if ($request->hasFile('attachment')) {
            // config
            $config = method_exists($this, 'defineConfig') ? $this->defineConfig() : config('sir-trevor-js');

            // file
            $file = $request->file('attachment');

            // Problem on some configurations
            $file = $file['file'] ?? $file;

            // filename
            $filename = $fileNameCheck = $file->getClientOriginalName();

            // prefix if file exists
            $prefix = 0;

            // verif if file exists
            while (file_exists(public_path($config['directory_upload']).'/'.$fileNameCheck)) {
                ++$prefix;

                if ($prefix < 10) {
                    $prefix = '0'.$prefix;
                }

                $fileNameCheck = $prefix.'_'.$filename;
            }

            $filename = $fileNameCheck;

            if (method_exists($this, 'afterUpload')) {
                $this->afterUpload($file, $filename);
            }

            if ($file->move(public_path($config['directory_upload']), $filename)) {
                $return = [
                    'file' => [
                        'url' => $config['directory_upload'].'/'.$filename,
                    ],
                ];

                echo json_encode($return);
            }
        }
    }

    /**
     * Tweet.
     */
    public function tweet(Request $request): void
    {
        // url of tweet.
        $tweetUrl = $request->input('tweet_id');

        if (! empty($tweetUrl)) {
            $tweetUrl = explode('?', $tweetUrl);
            $tweetUrl = $tweetUrl[0];

            $url = 'https://publish.twitter.com/oembed?url='.urlencode($tweetUrl).'&format=json';

            $result = file_get_contents($url);
            $decodedData = json_decode($result);

            // Tweet ID.
            $arrTweetID = explode('status/', $tweetUrl);
            $arrTweetID = explode('?', $arrTweetID[1]);
            $tweetID = $arrTweetID[0] ?? '';

            // Text.
            $text = strip_tags($decodedData->html ?? '');
            $arrText = explode('(@', $text);
            $text = str_replace($decodedData->author_name, '', $arrText[0]);

            // ScreenName.
            $arrScreenName = explode(')', $arrText[1] ?? '');
            $screenName = $arrScreenName[0] ?? '';
            // Date.
            $date = trim(str_replace("\n", '', $arrScreenName[1] ?? ''));

            echo json_encode([
                'id_str' => $tweetID,
                'text' => $text,
                'created_at' => $date,
                'status_url' => $tweetUrl,
                'user' => [
                    'name' => $decodedData->author_name,
                    'screen_name' => $screenName,
                ],
            ]);
        }
    }
}
