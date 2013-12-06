<?php

return array(
    // path for image uploads, from public_path (ex: img/uploads)
    "directory_upload" => "img/uploads",

    // path of Sir Trevor JS files from public (not mandatory, define in Caouecs\Sirtrevorjs\SirTrevorJs)
    "path" => null,

    // block types for Sir Trevor JS
    // by default: array('Text', 'List', 'Quote', 'Image', 'Video', 'Tweet', 'Heading')
    "blocktypes" => array(),

    // language
    // the file of translation must be in `locales` directory of your path
    "language" => "en"
);