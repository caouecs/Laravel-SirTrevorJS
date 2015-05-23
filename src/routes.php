<?php

// Route for upload images
Route::any('/sirtrevorjs/upload', ['uses' => '\Caouecs\Sirtrevorjs\Controller\SirTrevorJsController@upload']);

// Route for tweets
Route::any('/sirtrevorjs/tweet', ['uses' => '\Caouecs\Sirtrevorjs\Controller\SirTrevorJsController@tweet']);
