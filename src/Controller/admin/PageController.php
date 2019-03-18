<?php

namespace App\Controller\admin;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    public function page()
    {
        $repository = $this->getDoctrine()->getRepository(Page::class);
        $pages = $repository->findAll();
        return $this->render('admin/page.html.twig',
            ['pages' => $pages]);
    }
}
