<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FiliereRepository;
use App\Entity\Filiere;
use App\Form\PageType;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    public function page(FiliereRepository $repo)
    {
        return $this->render('admin/page.html.twig', ['pages' => $repo->findAll()]);
    }

    public function pageAdd()
    {
        $pageForm = $this->createForm(PageType::class, new Filiere);
        return $this->render('admin/page_add.html.twig', ['pageForm' => $pageForm->createView()]);
    }

    public function pageEdit(FiliereRepository $repo, $id)
    {

        return $this->render('admin/page_edit.html.twig', ['pages' => $repo->find($id)]);
    }
}
