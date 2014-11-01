<?php
// Route for upload images
Route::any("/sirtrevorjs/upload", array("uses" => "\Caouecs\Sirtrevorjs\Controllers\SirTrevorJsController@upload"));

// Route for tweets
Route::any("/sirtrevorjs/tweet", array("uses" => "\Caouecs\Sirtrevorjs\Controllers\SirTrevorJsController@tweet"));
