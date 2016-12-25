<?php

namespace KamiOrz\LumenHprose;

use Illuminate\Support\Facades\Facade;

class HproseServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "RpcService";
    }
}