<?php
ob_start();
include __DIR__ . "/../../env.config.php";
loadEnv();

function phpHead($title = 'Document', $description = '', $keywords = '', $extraMeta = ''){
    $jquery_location = "/common/headers/jquery-3.6.0.min.js";
    echo <<<HTML
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$title}</title>
        <meta name="description" content="{$description}">
        <meta name="keywords" content="{$keywords}">
        <script src="{$jquery_location}"
        ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
        {$extraMeta}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    </head>
HTML;
}
