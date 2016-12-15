<?php

namespace CI\Controllers;

use Core\Base\ApiController;

class ProjectController extends ApiController
{


    public function createAction()
    {
        return $this->json(__METHOD__);
    }


    public function getAction($id)
    {
        return $this->json(['id' => $id]);
    }


    public function listAction()
    {
        return $this->json(__METHOD__);
    }


    public function updateAction($id)
    {
        return $this->json(__METHOD__);
    }


    public function deleteAction($id)
    {
        return $this->json(__METHOD__);
    }
}
