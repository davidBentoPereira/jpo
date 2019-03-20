<?php

namespace App\Controller\admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FiliereRepository;
use App\Entity\Filiere;
use App\Form\PageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{
    public function page(FiliereRepository $repo): Response
    {
        return $this->render('admin/page.html.twig', ['filieres' => $repo->findAll()]);
    }

    public function pageAdd(Request $request, EntityManagerInterface $em): Response
    {
        $filiere = new Filiere;
        $pageForm = $this->createForm(PageType::class, $filiere);

        $pageForm->handleRequest($request);

        if ($pageForm->isSubmitted() && $pageForm->isValid())
        {
            $em->persist($pageForm->getData());
            $em->flush();

            $this->addFlash('success', 'La nouvelle filière a bien été ajouté.');

            return $this->redirectToRoute('page_add');
        }

        return $this->render('admin/page_add.html.twig', ['pageForm' => $pageForm->createView()]);
    }

    public function pageEdit(Request $request, EntityManagerInterface $em, FiliereRepository $repo, $id): Response
    {
        $filiere = $repo->find($id);
        $pageForm = $this->createForm(PageType::class, $filiere);
        $pageForm->handleRequest($request);

        if ($pageForm->isSubmitted() && $pageForm->isValid())
        {
            $em->persist($pageForm->getData());
            $em->flush();
            $this->addFlash('success', 'La filière a bien été modifié.');

            return $this->redirectToRoute('page_edit', ['id' => $id]);
        }

        return $this->render('admin/page_edit.html.twig', ['pageForm' => $pageForm->createView()]);
    }

    public function pageDelete($id, FiliereRepository $repo)
    {
        $repo->deleteFiliere($id);
        return $this->redirectToRoute('page');
    }
}
