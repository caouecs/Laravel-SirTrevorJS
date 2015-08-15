Laravel-SirTrevorJS
====================

Integrate the tool [Sir Trevor JS](http://madebymany.github.io/sir-trevor-js/) in a [Laravel 4/5](http://laravel.com) project.

## Installation

This package is available through `Packagist` and `Composer`.

 > **For Laravel 5.1*, use the [branch master](https://github.com/caouecs/Laravel-SirTrevorJS/tree/master) : `"caouecs/sirtrevorjs": "~2.1"`

 > **For Laravel 5**, use the [branch v2](https://github.com/caouecs/Laravel-SirTrevorJS/tree/v2) : `"caouecs/sirtrevorjs": "~2.0"`

> **For Laravel 4**, use the [branch laravel4](https://github.com/caouecs/Laravel-SirTrevorJS/tree/laravel4) : `"caouecs/sirtrevorjs": "~1.4"`

### Aliases

In your `app/config/app.php`, add in aliases :

    'SirTrevorJs' => 'Caouecs\Sirtrevorjs\SirTrevorJs',
    'STConverter' => 'Caouecs\Sirtrevorjs\SirTrevorJsConverter'

### Service Provider

If you want to use routing, controllers, views directly in your project, in your `app/config/app.php`, add `"Caouecs\Sirtrevorjs\SirtrevorjsServiceProvider"` to your list of providers.

### thujohn/twitter

To get tweets, this project uses [thujohn/twitter](https://github.com/thujohn/twitter). Please with the page of the project to know how to install and configure.

## Configuration file

Next, you must migrate config :

    php artisan vendor:publish caouecs/sirtrevorjs

After installation, the config file is located at *app/config/packages/caouecs/sirtrevorjs/sir-trevor-js.php*.

You can define :

* the path for image upload
* the route for upload image
* the route for tweet
* the path of Sir Trevor files
* the list of block types
* the language
* the paths for Eventable.js and Underscore.js
* the view
* configuration for blocks
    * soundcloud
    * gettyimages
* etc...

## SirTrevorJs class

### Assets

For stylesheets :

    SirTrevorJs::stylesheets()

For scripts, in your Blade files :

    SirTrevorJs::scripts()

### Fix for image block

Function to fix a problem with image block when you add a new image :

    $text = SirTrevorJs::transformText($text);

### Find first image

Get first image in text with `findImage` method :

    string SirTrevorJS::findImage(string $text);

In return, you have url of image or empty string.

### Find elements by blocktypes

Get all elements in text, in specified blocktype with `find` method :

    mixed SirTrevorJS::find(string $text, string $blocktype [, string $output = "json"])

In return, you can have :

* array, if you choose "array" for $output
* json, if you choose "json" for $output
* false, if the script doesn't find an occurence of blocktype

## Controller

### For Laravel 5 : SirTrevorJsController

This class proposes two things :

* upload image where you want
* get tweets

The routes are in the provider.

### For Laravel 5.1 : TraitSirTrevorJsController

This trait proposes two things :

* upload image where you want
* get tweets

### Upload image

This project proposes a system for upload image, nothing to configure, just the `directory_upload` value in config file.

    "directory_upload" => "img/uploads"

### Tweet

This project proposes a system to get tweets. I use [thujohn/twitter](https://github.com/thujohn/twitter) project.

## SirTrevorJsConverter class (or STConverter class)

Convert text from Sir Trevor Js to html :

    $convert = new STConverter();
    $convert->toHtml($text)


Or via SirTrevorJS class :

    {{ SirTrevorJs::render($text) }}

For the moment, the code can convert :

* blockquote / quote
* embedly card
* [facebook post](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/facebook.js)
* [getty images](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/gettyimage.js)
* heading
* image
    * basic version
    * [version with caption](https://github.com/neyre/sir-trevor-wp/blob/master/custom-blocks/ImageCaption.js)
* [issuu](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/issuu.js)
* [pinterest](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/pinterest.js)
* [sketchfab](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/sketchfab.js)
* [slideshare](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/slideshare.js)
* [soundcloud](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/soundcloud.js)
* [spotify](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/spotify.js)
* text with Markdown
* tweet
* unordered list
* [video](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/video.js)
    * aol
    * canal plus
    * daily mail uk
    * dailymotion
    * france tv
    * global news
    * livestream
    * metacafe
    * metatube
    * mlb
    * nbc bay area
    * nhl
    * ooyala
    * redtube
    * ustream (live and recorded)
    * veoh
    * vevo
    * vimeo
    * vine
    * wat
    * yahoo
    * youtube
    * zoomin.tv
    * video with caption
