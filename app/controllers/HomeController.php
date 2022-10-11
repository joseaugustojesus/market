<?php

namespace app\controllers;

class HomeController extends Controller
{
    /**
     * Method responsible for rendering dashboard
     *
     * @return void
     */
    public function index()
    {
        return $this->view('home');
    }
}
