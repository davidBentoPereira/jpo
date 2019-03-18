<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

}
