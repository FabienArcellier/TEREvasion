<?php

use Symfony\Component\HttpFoundation\Request;

// web/index.php
$autoloader = require_once __DIR__.'/../vendor/autoload.php';
$autoloader -> add('App', __DIR__.'/..');

$app = new Silex\Application();

// IOC
$app['logger'] = $app -> share(function(){
  return new App\Logger\LoggerPhp();
});
$app['config'] = $app -> share(function($app){
  return new App\ConfigIni('../resources/config.ini', $app['logger']);
});

$app['debug'] = $app['config'] -> get('application/debug');

/**
 * Routing rules
 */

/**
 * 
 */
$app -> get('/position/{latitude}/{longitude}', function(Silex\Application $app, $latitude, $longitude)
{  
  return $app -> json(array('latitude' => $latitude, 'longitude' => $longitude));
});

$app->run();