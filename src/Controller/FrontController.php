<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends AbstractController
{
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * Page Formations
     */
    public function formations(): Response
    {
        return $this->render('front/formations.html.twig');
    }

    /**
     * Page Filiere
     */
    public function filiere(): Response
    {
        return $this->render('front/filiere.html.twig');
    }

    /**
     * Page Dispositifs Spéciaux : ULIS => Unité Localisé pour l'Inclusion Scolaire
     */
    public function ulis(): Response
    {
        return $this->render('front/ulis.html.twig');
    }

    /**
     * Page Dispositifs Spéciaux : MLDS => Mission de Lutte contre le Décrochage Scolaire
     */
    public function mlds(): Response
    {
        return $this->render('front/mlds.html.twig');
    }

    /**
     * Page Sondages
     */
    public function sondages(): Response
    {
        return $this->render('front/sondages.html.twig');
    }

    /**
     * Page Sondage
     */
    public function sondage(): Response
    {
        return $this->render('front/sondage.html.twig');
    }

    /**
     * Page Histoire du Lycée
     */
    public function histoire(): Response
    {
        return $this->render('front/histoire.html.twig');
    }

}