<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Behavior;

use Illuminate\Http\Request;
use Thujohn\Twitter\Facades\Twitter;

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
     *
     * @param Request $request
     */
    public function upload(Request $request): void
    {
        if ($request->hasFile('attachment')) {
            // config
            $config = config('sir-trevor-js');

            // file
            $file = $request->file('attachment');

            // Problem on some configurations
            $file = (!method_exists($file, 'getClientOriginalName')) ? $file['file'] : $file;

            // filename
            $filename = $file->getClientOriginalName();

            // suffixe if file exists
            $suffixe = '01';

            // verif if file exists
            while (file_exists(public_path($config['directory_upload']).'/'.$filename)) {
                $filename = $suffixe.'_'.$filename;

                ++$suffixe;

                if ($suffixe < 10) {
                    $suffixe = '0'.$suffixe;
                }
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
     *
     * @param Request $request
     */
    public function tweet(Request $request): void
    {
        $tweet_id = $request->input('tweet_id');

        if (! empty($tweet_id)) {
            $tweet = Twitter::getTweet($tweet_id);

            if (false !== $tweet && ! empty($tweet)) {
                $return = [
                    'id_str' => $tweet_id,
                    'text' => '',
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
