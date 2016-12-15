<?php

namespace Core\Base;

use Symfony\Component\HttpFoundation\Response;

abstract class ApiController
{


    public function json($data, int $status = 200, array $headers = []): Response
    {
        $response = new Response(json_encode($data), $status, $headers);
        return $response;
    }
}
