<?php


namespace Paracall;


use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Yaml\Yaml;

/**
 * Class App
 *
 * Management Class for the App
 *
 * @package Paracall
 */
class App {

    protected $matcher;
    protected $resolver;
    protected $capsule;

    function __construct(UrlMatcher $matcher, ControllerResolver $resolver, Manager $capsule)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->capsule = $capsule;
    }

    protected function getDbConfig()
    {
        $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/app';

        return Yaml::parse($baseDir . '/Config/dbconfig.yml');
    }

    public function boot()
    {
        $dbconfig = $this->getDbConfig();

        $this->bootEloquent($dbconfig);
    }

    protected function bootEloquent($dbconfig)
    {
        $dbconfig = $dbconfig['connections'][$dbconfig['default_connection']];

        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $dbconfig['host'],
            'database'  => $dbconfig['database'],
            'username'  => $dbconfig['username'],
            'password'  => $dbconfig['password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]);

        $this->capsule->setEventDispatcher(new Dispatcher(new Container));
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    /**
     *
     * Handle the HTTP request, find the the associate Controller specified in the Route
     *
     * @param Request $request
     * @return mixed|Response
     */
    public function handle(Request $request)
    {
        try
        {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            return call_user_func($controller, $arguments);
        } catch (ResourceNotFoundException $e)
        {
            return new Response('Not Found', 404);
        }
    }
}