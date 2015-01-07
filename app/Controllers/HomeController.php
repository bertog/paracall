<?php


namespace Paracall\controllers;


class HomeController extends Controller{

    public function index(){

        return $this->renderView('home');

    }

}