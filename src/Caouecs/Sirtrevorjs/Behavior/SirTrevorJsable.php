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
            $filename = $file->getClientOriginalName();

            // prefix if file exists
            $prefix = '01';

            // verif if file exists
            while (file_exists(public_path($config['directory_upload']).'/'.$filename)) {
                $filename = $prefix.'_'.$filename;

                ++$prefix;

                if ($prefix < 10) {
                    $prefix = '0'.$prefix;
                }
            }

            if (method_exists($this, 'afterUpload')) {
                $this->afterUpload($file, $filename);
            }

            if ($file->move(public_path($config['directory_upload']), $filename)) {
                $return = [
                    'file' => [
                        'url' => '/'.$config['directory_upload'].'/'.$filename,
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
        $tweet_id = $request->input('tweet_id');

        if (! empty($tweet_id)) {
            $tweet = Twitter::getTweet($tweet_id);

            if ($tweet !== false && ! empty($tweet)) {
                $return = [
                    'id_str' => $tweet_id,
                    'text' => ! $tweet->truncated ? $tweet->text : '',
                    'created_at' => $tweet->created_at,
                    'user' => [
                        'name' => $tweet->user->name,
                        'screen_name' => $tweet->user->screen_name,
                        'profile_image_url' => $tweet->user->profile_image_url,
                        'profile_image_url_https' => $tweet->user->profile_image_url_https,
                    ],
                ];

                echo json_encode($return);
            }
        }
    }
}
