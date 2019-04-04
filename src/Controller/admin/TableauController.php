<?php

namespace App\Controller\admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TableauRepository;
use App\Entity\Tableau;
use App\Form\TableauType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TableauController extends AbstractController
{
    public function tableauList(TableauRepository $repo): Response
    {
        return $this->render('admin/tableau_list.html.twig', ['tableau' => $repo->findAll()]);
    }

//    public function tableauAdd(Request $request, EntityManagerInterface $em): Response
//    {
//        $filiere = new Filiere;
//        $pageForm = $this->createForm(PageType::class, $filiere);
//
//        $pageForm->handleRequest($request);
//
//        if ($pageForm->isSubmitted() && $pageForm->isValid())
//        {
//            $em->persist($pageForm->getData());
//            $em->flush();
//
//            $this->addFlash('success', 'La nouvelle filière a bien été ajouté.');
//
//            return $this->redirectToRoute('page_add');
//        }
//
//        return $this->render('admin/page_add.html.twig', ['pageForm' => $pageForm->createView()]);
//    }

    public function tableauEdit(Request $request, EntityManagerInterface $em, TableauRepository $repo, $id): Response
    {
        $tableau = $repo->find($id);
        $tableauForm = $this->createForm(TableauType::class, $tableau);
        $tableauForm->handleRequest($request);

        if ($tableauForm->isSubmitted() && $tableauForm->isValid())
        {
            $em->persist($tableauForm->getData());
            $em->flush();
            $this->addFlash('success', 'La filière a bien été modifié.');

            return $this->redirectToRoute('tableau_edit', ['id' => $id]);
        }

        return $this->render('admin/tableau_edit.html.twig', ['tableauForm' => $tableauForm->createView()]);
    }

//    public function tableauDelete($id, TableauRepository $repo)
//    {
//        $repo->deleteFiliere($id);
//        return $this->redirectToRoute('page');
//    }
}
