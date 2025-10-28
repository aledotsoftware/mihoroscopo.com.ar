<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{




    private $viewDirectory;


    public function __construct()
    {
        // Obtén la variable de entorno
        $this->viewDirectory = env('VIEW_DIRECTORY');
    }

    public function index()
    {


        // Pasa la variable a la vista
        return view('mihoroscopo/home'); // Muestra la landing page

    }
}
