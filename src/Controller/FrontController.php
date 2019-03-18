<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }
}