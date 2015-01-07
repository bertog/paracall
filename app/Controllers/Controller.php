<?php


namespace Paracall\Controllers;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;

abstract class Controller {

    public function renderView($view, Array $data = [])
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views/%name%.php');
        $templating = new PhpEngine(new TemplateNameParser(), $loader);

        return new Response($templating->render($view, $data));
    }

}