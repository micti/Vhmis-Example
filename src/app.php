<?php

use Vhmis\Http;
use Vhmis\Http\Server\Server;
use Vhmis\App\Application;

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Vhmis';

    // base directory for the namespace prefix
    $base_dir = '/WebServer/VHMIS/Framework/Vhmis';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

$app = new Application(__DIR__);
$app->loadConfig();
$app->get('/', function($app, $request, Http\ResponseInterface $response) {
    $content = 'hello, home page';
    $response->getBody()->write($content);
    
    return $response;
});

$app->get('/download', function($app, $request, Http\ResponseInterface $response) {
    $content = 'hello, download page';
    $response->getBody()->write($content);
    
    return $response;
});

$server = new Server($app);
$server->run();
