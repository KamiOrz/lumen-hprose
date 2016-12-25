# Hprose for Lumen 5.x

Hprose [https://github.com/hprose](https://github.com/hprose)

`HPROSE` is a High Performance Remote Object Service Engine.

It is a modern, lightweight, cross-language, cross-platform, object-oriented, high performance, remote dynamic communication middleware. 
It is not only easy to use, but powerful. 

## Installation

```
# composer
composer require kamiorz/lumen-hprose dev-master
```

## Configuration

```
# config/hprose.php
```

```php
# bootstrap/app.php
# include the provider
$app->register(KamiOrz\LumenHprose\HproseServiceProvider::class);

# include the alias
class_alias('TKamiOrz\LumenHprose\HproseClientFacade', 'RpcClient');
class_alias('TKamiOrz\LumenHprose\HproseServerFacade', 'RpcServer');
class_alias('TKamiOrz\LumenHprose\HproseServiceFacade', 'RpcService');

# Lumen config
sudo cp vendor/kamiorz/lumen-hprose/config/hprose.php config
```

## Usage

### Hprose client

```php
use RpcClient as Rpc;
$result = Rpc::someServerMethod($params);
```

### Hprose server

```php
Route::any('/api', function() {
    $server = app('RpcServer');
    
    // Hprose support XmlRPC and JsonRPC
    // if want support XmlRpc
    $server->addFilter(new Hprose\Filter\XMLRPC\ServiceFilter());
    // if want support JsonRpc
    $server->addFilter(new Hprose\Filter\JSONRPC\ServiceFilter());
    
    $server->addInstanceMethods(new \App\Services\SomeHprosePublishServices());
    $server->start();
});
```

### Middleware setting

```php
# app/Http/Middleware/VerifyCsrfToken.php
[...]
protected $except = [
    'api' // OR 'api*'
];
```

### API Reference

Please refer to [https://github.com/hprose/hprose-php](https://github.com/hprose/hprose-php)