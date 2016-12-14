<?php

namespace Core;

use Symfony\Component\HttpFoundation\Request;

class Router extends Obj
{


    public function dispatch(Request $request)
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
        $controller = new $controllerName();
        $method = $request->getMethod();

        if ($method == 'GET' && $resourceId == '') {
            return call_user_func_array([$controller, 'listAction'], []);
        } elseif ($method == 'GET' && $resourceId != '') {
            return call_user_func_array([$controller, 'getAction'], [$resourceId]);
        } elseif ($method == 'POST' && $resourceId == '') {
            return call_user_func_array([$controller, 'createAction'], []);
        } elseif ($method == 'PUT' && $resourceId != '') {
            return call_user_func_array([$controller, 'updateAction'], [$resourceId]);
        } elseif ($method == 'DELETE' && $resourceId != '') {
            return call_user_func_array([$controller, 'deleteAction'], [$resourceId]);
        } else {
            return false;
        }
    }
}
