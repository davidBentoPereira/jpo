<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * Page Accueil
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * Page Histoire du Lycée
     */
    public function histoire()
    {
        return $this->render('front/histoire.html.twig');
    }

}