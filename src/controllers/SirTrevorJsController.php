<?php
use Thujohn\Twitter\TwitterFacade as Tweet;

class SirTrevorJsController extends BaseController
{
    /**
     * Upload image
     *
     * you can define `directory_upload` in config file
     *
     * @access public
     * @return string Data for Sir Trevor or Error
     */
    public function upload()
    {
        if (isset($_FILES["attachment"])) {

            // config
            $config = Config::get("sirtrevorjs::sir-trevor-js");

            // filename
            $filename = $_FILES['attachment']['name']['file'];

            // verif if files exists
            $i = "01";

            while (file_exists(public_path($config['directory_upload'])."/".$filename)) {
                $filename = $i."_".$filename;

                $i++;

                if ($i < 10) {
                    $i = "0".$i;
                }
            }

            if (move_uploaded_file(
                $_FILES["attachment"]["tmp_name"]['file'],
                public_path($config['directory_upload'])."/".$filename
            )) {

                $return = array(
                    "file" => array(
                        "url" => "/".$config['directory_upload']."/".$filename
                    )
                );

                echo json_encode($return);
            }
        }
    }

    /**
     * Tweet
     *
     * @access public
     * @return string
     */
    public function tweet()
    {
        $input = Input::all();

        $tweet_id = isset($input['tweet_id']) ? e($input['tweet_id']) : null;

        if ($tweet_id == null) {
            return null;
        }

        $tweet = Tweet::getTweet($tweet_id);

        if ($tweet != false && $tweet != null) {
            $return = array(
                "id_str"     => $tweet_id,
                "text"       => $tweet->text,
                "created_at" => $tweet->created_at,
                "user"       => array(
                    "name"                    => $tweet->user->name,
                    "screen_name"             => $tweet->user->screen_name,
                    "profile_image_url"       => $tweet->user->profile_image_url,
                    "profile_image_url_https" => $tweet->user->profile_image_url_https
                )
            );

            echo json_encode($return);
        }
    }
}
