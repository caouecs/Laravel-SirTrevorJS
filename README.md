Laravel-SirTrevorJS
====================

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=caouecs_Laravel-SirTrevorJS&metric=alert_status)](https://sonarcloud.io/dashboard?id=caouecs_Laravel-SirTrevorJS)


Integrate the tool [Sir Trevor JS](http://madebymany.github.io/sir-trevor-js/) in a [Laravel 5/6/7](http://laravel.com) project.

## Installation

This package is available through `Packagist` and `Composer`.

 > **For PHP 7** version with new API, use the [branch master](https://github.com/caouecs/Laravel-SirTrevorJS/tree/master) : `"caouecs/sirtrevorjs": "~4.0.0"`
 > **For PHP 7** version, use the [branch v3.0](https://github.com/caouecs/Laravel-SirTrevorJS/tree/v3.0) : `"caouecs/sirtrevorjs": "~3.0.0"`

 > **For Laravel >= 5.2** version *parser*, use the [branch v2.5](https://github.com/caouecs/Laravel-SirTrevorJS/tree/2.5) : `"caouecs/sirtrevorjs": "~2.5.0"`

 > **For Laravel >= 5.1** version *js & amp*, use the [branch v2.4](https://github.com/caouecs/Laravel-SirTrevorJS/tree/v2.4) : `"caouecs/sirtrevorjs": "~2.4.0"`

 > **For Laravel >= 5.1** version *fb articles*, use the [branch v2.3](https://github.com/caouecs/Laravel-SirTrevorJS/tree/v2.3) : `"caouecs/sirtrevorjs": "~2.3.0"`

 > **For Laravel >= 5.1** version *view & amp*, use the [branch v2.2](https://github.com/caouecs/Laravel-SirTrevorJS/tree/v2.2) : `"caouecs/sirtrevorjs": "~2.2.0"`

 > **For Laravel >= 5.1** version *base*, use the [branch v2.1](https://github.com/caouecs/Laravel-SirTrevorJS/tree/v2.1) : `"caouecs/sirtrevorjs": "~2.1.0"`

 > **For Laravel 5.0**, use the [branch v2](https://github.com/caouecs/Laravel-SirTrevorJS/tree/v2) : `"caouecs/sirtrevorjs": "~2.0.0"`

 > **For Laravel 4**, use the [branch laravel4](https://github.com/caouecs/Laravel-SirTrevorJS/tree/laravel4) : `"caouecs/sirtrevorjs": "~1.4"`

Please read *README.md* in the choosen branch.

### Service Provider

If you want to use routing, controllers, views, binding directly in your project, in your `app/config/app.php`, add `"Caouecs\Sirtrevorjs\SirtrevorjsServiceProvider"` to your list of providers.

### thujohn/twitter

To get tweets, this project uses [thujohn/twitter](https://github.com/thujohn/twitter). Please visit the page of the project to know how to install and configure.

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
* custom blocks
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

```php
    SirTrevorJs::stylesheets()
```

For scripts, in your Blade files :

```php
    SirTrevorJs::scripts()
```

### Fix for image block

Function to fix a problem with image block when you add a new image :

```php
    string SirTrevorJs::transformText(string $text);
```

### Find first image

Get first image in text with `findImage` method :

```php
    string SirTrevorJS::findImage(string $text);
```

In return, you have url of image or empty string.

### Find elements by blocktypes

Get all elements in text, in specified blocktype with `find` method :

```php
    mixed SirTrevorJS::find(string $text, string $blocktype [, string $output = "json"])
```

In return, you can have :

* array, if you choose "array" for $output
* json, if you choose "json" for $output
* false, if the script doesn't find an occurence of blocktype

## Controller

### SirTrevorJsable

This trait proposes two things :

* upload image where you want
* get tweets

### Upload image

This project proposes a system for upload image, nothing to configure, just the `directory_upload` value in config file.

```php
    "directory_upload" => "img/uploads"
```

### Tweet

This project proposes a system to get tweets. I use [thujohn/twitter](https://github.com/thujohn/twitter) project.

## SirTrevorJsConverter class

This class need a parser, a configuration and a view by default.

You can use the binding of this class :

```php
    App::make('caouecs.sirtrevorjs.converter')
```

### Html

Convert text from Sir Trevor Js to html :

```php
    string App::make('caouecs.sirtrevorjs.converter')->toHtml($text)
```

These methods return a string with html and js codes.

### Amp

Convert text from Sir Trevor Js to [Amp](https://www.ampproject.org):

```php
    string App::make('caouecs.sirtrevorjs.converter')->toAmp($text);
```

All modules have an amp's version, if it exists an equivalence.

This method returns an array ( *text* and *js*).

### Facebook Instant Articles

Convert text from Sir Trevor Js to [Facebook Instant Articles](https://developers.facebook.com/docs/instant-articles/reference):

```php
    string App::make('caouecs.sirtrevorjs.converter')->toFb($text);
```

All modules have an FBArticles's version, if it exists an equivalence.

This method returns a string with html and js codes.

### Adding custom blocks

You can choose to add custom blocks in config file or add them by extending SirTrevorJsConverter class.

#### config

```php
'customBlocks' => [
    'image_extended' => '\App\SirTrevorConverters\ImageExtendedConverter',
],
```

#### SirTrevorConverter

```php
<?php
namespace App\SirTrevorConverters;

use \Caouecs\Sirtrevorjs\SirTrevorJsConverter;

class SirTrevorJsConverterEditor extends SirTrevorJsConverter
{
    /**
     * Custom blocks.
     *
     * @var array
     */
    protected $customBlocks = [
        'gallery' => '{Your namespace}\\Editor\\Converter\\GalleryConverterEditor',
        'readmore' => '{Your namespace}\\Editor\\Converter\\ReadMoreConverterEditor',
    ];
}
```

And you need to call this class in your service provider, in register :

    $this->app->bind('editor.converter', function ($app) {
        return new App\SirTrevorConverters\SirTrevorJsConverterEditor(
            new ParsedownExtraParser(),
            config('sir-trevor-js'),
            'html'
        );
    });

### Modules

For the moment, the code can convert :

* blockquote / quote
* embedly card
* [facebook post](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/facebook.js)
* [getty images](https://github.com/caouecs/SirTrevorJS-blocks/blob/master/blocks/gettyimage.js)
* heading
* [iframe](https://raw.githubusercontent.com/madebymany/sir-trevor-blocks/6b2ba248b49c13eb38f84c1267c5779a18cd4201/src/iframe.js)
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
