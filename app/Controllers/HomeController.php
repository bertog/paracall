<?php


namespace Paracall\Controllers;


class HomeController extends Controller{

    public function index(){

        return $this->renderView('home');

    }

}