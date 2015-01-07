<?php

use Paracall\App;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/vendor/autoload.php';

$capsule = new Capsule;

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/app/routes.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
$resolver = new ControllerResolver();

$App = new App($matcher, $resolver, $capsule);
$App->bootEloquent();

$response = $App->handle($request);

$response->send();

