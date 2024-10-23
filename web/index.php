<?php

use Symfony\Component\HttpFoundation\Request;

// Update the autoloader path to go one level up to the root vendor directory
$autoloader = require_once __DIR__ . '/../vendor/autoload.php';

$kernel = \Drupal\Core\DrupalKernel::createFromRequest(Request::createFromGlobals(), $autoloader, 'prod');

// Handle the request and generate the response.
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

// After sending the response to the client, terminate the kernel.
$kernel->terminate($request, $response);
