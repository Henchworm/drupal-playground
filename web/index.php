<?php

use Symfony\Component\HttpFoundation\Request;

$autoloader = require_once __DIR__ . '/autoload.php';
$kernel = \Drupal\Core\DrupalKernel::createFromRequest(Request::createFromGlobals(), $autoloader, 'prod');
$response = $kernel->handle(Request::createFromGlobals());
$response->send();
$kernel->terminate(Request::createFromGlobals(), $response);
