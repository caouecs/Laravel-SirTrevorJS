<?php

return array(
    // path for image uploads, from public_path (ex: img/uploads)
    "directory_upload" => "img/uploads",

    // upload url for image
    // by default: /sirtrevorjs/upload (the controller of this package)
    "uploadUrl" => null,

    // url for tweet
    // by default: /sirtrevorjs/tweet (the controller of this package)
    "tweetUrl" => null,

    // block types for Sir Trevor JS
    // by default: array('Text', 'List', 'Quote', 'Image', 'Video', 'Tweet', 'Heading')
    "blocktypes" => array(),

    // language
    // the file of translation must be in `locales` directory of your path
    "language" => "en",

    // path of Sir Trevor JS files from public_path()
    "path" => "/asset/sirtrevorjs/",

    // others stylesheet files path from public_path()
    //   not files of Sir Trevor JS
    "stylesheet" => array(),

    // others javascript files path from public_path()
    //   not files of Sir Trevor JS
    //
    // because Sir Trevor JS needs Underscore.js and Eventable.js
    "script" => array(
        "/asset/underscore-min.1.4.4.js",
        "/asset/eventable.js"
    ),

    // type of soundcloud
    // small or full
    "songcloud" => "small",

    // Getty Images
    "gettyimages" => array(
        "width"  => 594,
        "height" => 465
    ),

    // Embedly
    "embedly" => array(
        "card" => array(
            "dark" => false,
            "analytics" => false
        )
    ),

    // Spotify
    "spotify" => array(
        "width" => 300,
        "height" => 380
    )
);
