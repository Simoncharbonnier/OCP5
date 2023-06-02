<?php

require_once 'app/controllers/Controller.php';

class Erreur extends Controller
{

    /**
     * Display the error page
     *
     * @return void
    */

    public function index() : void
    {
        include_once 'app/views/erreur/index.php';
    }
}
