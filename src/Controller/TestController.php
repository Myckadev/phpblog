<?php

namespace App\Controller;

class TestController extends AbstractController
{

    public function home() 
    {
        return $this->render('base.twig', ['var' => 'Hello World']);
    }

    public function list()
    {
        echo 'JE SUIS LA LIST';
    
    }
}