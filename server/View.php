<?php

declare(strict_types = 1);

namespace App;

use \App\Utils\{Request, Response};

class View {

    public static function index(Request $req, Response $res): void {
        // $res->sendFile(PUBLIC_DIR . '/index.html');
        echo 'from staticfiles index';
    }

    public static function resource(Request $req, Response $res): void {
        // to-do 404 when file not found
        // $res->sendFile(PUBLIC_DIR . '');
        echo 'from staticfiles servestatic';
    }
}