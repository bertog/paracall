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

    public function bootEloquent()
    {
        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'paracall',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
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