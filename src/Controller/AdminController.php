<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    public function page()
    {
        return $this->render('admin/page.html.twig');
    }

    public function event()
    {
        return $this->render('admin/event.html.twig');
    }

    public function survey()
    {
        return $this->render('admin/survey.html.twig');
    }
}
