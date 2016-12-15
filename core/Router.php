<?php

namespace Core;

use Core\Exceptions\MethodNotExists;
use Core\Exceptions\RouteNotFound;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router extends Obj
{


    public function dispatch(Request $request): Response
    {
        $originalUri = $request->getRequestUri();
        $canonicalUri = trim($originalUri, '/');
        $driedUri = '/' . trim(trim($canonicalUri, '0123456789'), '/');
        $resourceId = trim(ltrim($canonicalUri, $driedUri), '/');
        $pathComponents = explode('/', trim($driedUri, '/'));
        $controllerName = '';
        foreach ($pathComponents as $component) {
            $controllerName .= "\\" . ucfirst($component);
        }

        $controllerName = 'CI\Controllers' . $controllerName . 'Controller';
        if (!class_exists($controllerName)) {
            throw new RouteNotFound();
        }
        $controller = new $controllerName();
        $method = $request->getMethod();

        if ($method == 'GET' && $resourceId == '') {
            $this->assertMethodExists($controller, 'listAction');
            return call_user_func_array([$controller, 'listAction'], []);
        } elseif ($method == 'GET' && $resourceId != '') {
            $this->assertMethodExists($controller, 'getAction');
            return call_user_func_array([$controller, 'getAction'], [$resourceId]);
        } elseif ($method == 'POST' && $resourceId == '') {
            $this->assertMethodExists($controller, 'createAction');
            return call_user_func_array([$controller, 'createAction'], []);
        } elseif ($method == 'PUT' && $resourceId != '') {
            $this->assertMethodExists($controller, 'updateAction');
            return call_user_func_array([$controller, 'updateAction'], [$resourceId]);
        } elseif ($method == 'DELETE' && $resourceId != '') {
            $this->assertMethodExists($controller, 'deleteAction');
            return call_user_func_array([$controller, 'deleteAction'], [$resourceId]);
        } else {
            throw new RouteNotFound();
        }
    }


    public function assertMethodExists($controller, $method)
    {
        if (!method_exists($controller, $method)) {
            throw new MethodNotExists();
        }
    }
}
