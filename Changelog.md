# Changelog

* v4.3.0
    * add transformerText function in Parsable

* v4.2.0
    * rollback on tweetic

* v4.1.3
    * feature: you can define a method defineConfig to define other configuration file for the upload. Useful if you have multi configuration in your website
    * fix: prefix for images

* v4.1.2
    * fix: View:exists

* v4.1.1
    * feature: rollback on tweets with text. For smiley, you need an SQL encoding for binaries

* v4.1.0
    * feature: twitter by tweetic

* v4.0.2
    * documentation

* v4.0.1
    * fix: upload image and possibility to call a afterUpload method

* v4.0.0
    * for PHP 8
    * for Laravel 9
    * feature: loading lazy for iframe
    * feature: #31 from abad93/patch-2
    * feature: #32 from abad93/patch-1
    * feature: parser by Laravel Str markdown
    * feature: atymic/twitter
    * fix: call to twitter facade
    * fix: blockquote with multi lines

* v3.0.6
    * fix: use Parsedown Extra Parser

* v3.0.5
    * feature: http to https

* v3.0.4
    * remove: code sponsor

* v3.0.3
    * feature: blockquote - html5
    * feature: add alt for images

* v3.0.2
    * optim: trait controller - tweet
    * feature: operator

* v3.0.1
    * feature: Package Auto-Discovery for Laravel 5.5

* v3.0.0
    * feature: php7

* v2.5.9
    * feature: https everywhere

* v2.5.8
    * fix: type of variable for PHP7

* v2.5.7
    * fix: converter - fb

* v2.5.6
    * feature: social - tweet template

* v2.5.5
    * feature: tweet and truncated

* v2.5.4
    * feature: amp - update for Facebook and Vine
    * fix: image

* v2.5.3
    * fix: empty on array

* v2.5.2
    * feature: image - add width and height

* v2.5.1
    * fix: service provider - use for ParsedownExtraParser

* v2.5.0
    * bind the converters

* v2.4.8
    * fix: fb - social - Facebook view
    * fix: twitter view

* v2.4.7
    * fix: composer
    * fix: base converter

* v2.4.6
    * preparation for tests

* v2.4.5
    * fix: amp - gettyimage
    * fix: #29 laravel collective html package

* v2.4.4
    * fix: tweet - html - include js

* v2.4.3
    * fix: tweet - fb - not op-social

* v2.4.2
    * getJsExternal method

* v2.4.1
    * fix gettyimages for amp
    * new config variable for gettyimages placeholder

* v2.4.0
    * js and amp

* v2.3.6
    * fix: fb views - Facebook and Twitter

* v2.3.5
    * feature: views - https by default

* v2.3.4
    * custom blocks in config file

* v2.3.3
    * custom blocks

* v2.3
    * Facebook Articles with views

* v2.2
    * Html views in *html* directory
    * Amp views in *amp* directory
    * possibility to define multi views in same application

* v2.1.4
    * fix tweet render with @

* v2.1.3
    * fix find() and unlimited

* v2.1.1
    * fix for title

* v2.1
    * trait for controller

* v2.0
    * version for Laravel 5

* v1.4.0
    * class Converter
    * views for render

* v1.3.0
    * no public directory needed

* v1.2.4
    * cleaning

* v1.2.3
    * fix for blockquoteToHtml

* v1.2.2
    * add nbc bay area videos

* v1.2.1
    * New composer

* v1.2.0
    * Parsedown Extra for Markdown text

* v1.1.10
    * add ooyala videos

* v1.1.9
    * add livestream videos

* v1.1.8
    * add nhl videos

* v1.1.7
    * add soundcloud players
    * possibility to choose type of player in config file

* v1.1.6
    * add global news videos

* v1.1.5
    * add zoomin.tv

* v1.1.4
    * add converter for issuu

* v1.1.3
    * add converter for france tv video
    * add converter for sketchlab

* v1.1.2
    * add converter for video with caption
    * add converter for pin from pinterest
    * add converter for canal plus video

* v1.1.1
    * add converter for embedly card
    * update SirTrevorJsConverter class with no duplicate call of js
    * add quoteToHtml() for quote blocks ( see [#3](https://github.com/caouecs/Laravel4-SirTrevorJS/issues/3) )

* v1.1.0
    * update SirTrevorJsConverter::imageToHtml() with html element, figure
    * update SirTrevorJsConverter::imageToHtml() for image with caption

* v1.0.7
    * add converter for ustream recorded video

* v1.0.6
    * add converter for aol video
    * add converter for metatube video
    * add converter for wat.tv video
    * add converter for daily mail uk video
    * add converter for Spotify track

* v1.0.5
    * add converter for metacafe video
    * add converter for yahoo video
    * add converter for ustream video
    * add converter for veoh video
    * add converter for vevo video

* v1.0.4
    * add converter for getty image
    * add converter for slideshare
    * add converter for facebook post

* v1.0.3
    * fix on tweets

* v1.0.2
    * fix on upload image

* v1.0.0
    * update of readme.md
    * new management of stylesheet and script files
    * v0.3.2 of Sir Trevor JS
    * fix for SirTrevorJS::scripts()

* v0.1.0
    * add possibility to change language
    * v0.3.1 of Sir Trevor Js
