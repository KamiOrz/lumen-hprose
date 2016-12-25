<?php

namespace KamiOrz\LumenHprose;

use Illuminate\Support\Facades\Facade;

class HproseServerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "RpcServer";
    }
}