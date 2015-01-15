<?php


namespace Paracall\Controllers;


use Paracall\Authentication\Auth;
use Paracall\Authentication\UserCredentials;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller {

    public function index()
    {
        $credentials = new UserCredentials('bertog', 'secret');

        try
        {
            Auth::attempt($credentials);
        } catch (\Exception $e)
        {
            echo $e->getMessage();
        }

        $data = [
            'check' => Auth::check(),
            'hash' => Auth::hash('piciu'),
            'loggedUser' => Auth::$LoggedUser,
        ];

        return $this->renderView('auth', compact('data'));


   }

}