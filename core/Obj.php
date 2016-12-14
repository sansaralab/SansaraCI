<?php

namespace Core;

class Obj
{


    protected function __construct()
    {
    }


    public static function factory()
    {
        return new static();
    }
}
