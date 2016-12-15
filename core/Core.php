<?php

namespace Core;

use Core\Exceptions\MethodNotExists;
use Core\Exceptions\RouteNotFound;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Core
{


    public function run()
    {
        $request = Request::createFromGlobals();
        try {
            $response = Router::factory()->dispatch($request);
        } catch (MethodNotExists $ex) {
            $data = json_encode([
                'ok' => false,
                'error' => 'Method not exists'
            ]);
            Response::create($data, 404)->send();
            return;
        } catch (RouteNotFound $ex) {
            $data = json_encode([
                'ok' => false,
                'error' => 'Method not exists'
            ]);
            Response::create($data, 404)->send();
            return;
        }

        $response->send();
    }
}
