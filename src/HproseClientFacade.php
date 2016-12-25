<?php

namespace KamiOrz\LumenHprose;

use Illuminate\Support\Facades\Facade;

class HproseClientFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "RpcClient";
    }
}