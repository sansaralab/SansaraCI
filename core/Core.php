<?php

namespace Core;

use Symfony\Component\HttpFoundation\Request;

class Core
{


    public function registerRoutes()
    {
    }


    public function run()
    {
        $request = Request::createFromGlobals();
        Router::factory()
            ->dispatch($request);
    }
}
