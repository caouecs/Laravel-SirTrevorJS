<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Controller;

use Config;
use Controller;
use Input;
use Thujohn\Twitter\TwitterFacade as Tweet;

/**
 * Controller Sir Trevor Js
 * - upload image
 * - display tweet.
 */
class SirTrevorJsController extends Controller
{
    /**
     * Upload image.
     *
     * you can define `directory_upload` in config file
     *
     * @return string Data for Sir Trevor or Error
     */
    public function upload()
    {
        if (Input::hasFile('attachment')) {
            // config
            $config = Config::get('sir-trevor-js');

            // file
            $file = Input::file('attachment');

            // Problem on some configurations
            $file = (!method_exists($file, 'getClientOriginalName')) ? $file['file'] : $file;

            // filename
            $filename = $file->getClientOriginalName();

            // suffixe if file exists
            $suffixe = '01';

            // verif if file exists
            while (file_exists(public_path($config['directory_upload']).'/'.$filename)) {
                $filename = $suffixe.'_'.$filename;

                $suffixe++;

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
     * @return string
     */
    public function tweet()
    {
        $tweet_id = array_get(Input::all(), 'tweet_id');

        if (empty($tweet_id)) {
            return;
        }

        $tweet = Tweet::getTweet($tweet_id);

        if ($tweet !== false && !empty($tweet)) {
            $return = [
                'id_str'     => $tweet_id,
                'text'       => $tweet->text,
                'created_at' => $tweet->created_at,
                'user'       => [
                    'name'                    => $tweet->user->name,
                    'screen_name'             => $tweet->user->screen_name,
                    'profile_image_url'       => $tweet->user->profile_image_url,
                    'profile_image_url_https' => $tweet->user->profile_image_url_https,
                ],
            ];

            echo json_encode($return);
        }
    }
}
