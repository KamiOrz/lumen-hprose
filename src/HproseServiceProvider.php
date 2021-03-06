<?php

namespace KamiOrz\LumenHprose;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Hprose;

class HproseServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        // vendor:publish 生成配置文件
        $configPath = __DIR__ . '/../config/hprose.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('hprose.php');
        } else {
            $publishPath = base_path('config/hprose.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');

        // 设置别名
        $loader = AliasLoader::getInstance();
        $loader->alias('RpcClient', 'Laoliu\LaravelHprose\HproseClientFacade');
        $loader->alias('RpcServer', 'Laoliu\LaravelHprose\HproseServerFacade');
        $loader->alias('RpcService', 'Laoliu\LaravelHprose\HproseServiceFacade');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/hprose.php', 'hprose');

        $this->app->singleton('RpcService', function(){
            return new Hprose\Http\Service();
        });

        $this->app->bind('RpcClient', function(){
            $options = $this->app["config"]->get("hprose.client");
            $client = new HproseClientWrapper($options);
            return $client;
        });

        $this->app->bind('RpcServer', function(){
            $options = $this->app["config"]->get("hprose.server");
            $server = new Hprose\Http\Server();

            if(is_array($options) && count($options)){
                foreach ($options as $k => $option) {
                    $setMethod = 'set' . $k;
                    if (method_exists($server, $setMethod) && $option){
                        $server->$setMethod($option);
                    }
                }
            }

            return $server;
        });
    }

    protected function mergeConfigFrom($path, $key='hprose')
    {
        $config_usr = $this->app["config"]->get($key, []);
        $config_pkg = require $path;

        $config = [];
        $config["client"] = array_merge($config_pkg["client"], @$config_usr["client"] ?: []);
        $config["server"] = array_merge($config_pkg["server"], @$config_usr["server"] ?: []);

        $this->app["config"]->set($key, $config);
    }

    public function provides()
    {
        return ["RpcClient", "RpcServer", "RpcService"];
    }
}