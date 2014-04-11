<?php
// Route for upload images
Route::any("/sirtrevorjs/upload", array("uses" => "SirTrevorJsController@upload"));

// Route for tweets
Route::any("/sirtrevorjs/tweet", array("uses" => "SirTrevorJsController@tweet"));
