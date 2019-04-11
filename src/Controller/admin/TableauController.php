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
        return $this->render('admin/tableau_list.html.twig', ['tableau' => $repo->findAllLinesInTableauSortedByRank()]);
    }

    public function tableauAdd(Request $request, EntityManagerInterface $em): Response
    {
        $tableau = new Tableau;
        $tableauForm = $this->createForm(TableauType::class, $tableau);

        $tableauForm->handleRequest($request);

        if ($tableauForm->isSubmitted() && $tableauForm->isValid())
        {
            $em->persist($tableauForm->getData());
            $em->flush();

            $this->addFlash('success', 'La nouvelle ligne a bien été ajouté au tableau des formations.');

            return $this->redirectToRoute('tableau_add');
        }

        return $this->render('admin/tableau_add_or_edit.html.twig', [
            'tableauForm' => $tableauForm->createView(),
            'type' => 'add'
            ]);
    }

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

        return $this->render('admin/tableau_add_or_edit.html.twig', [
            'tableauForm' => $tableauForm->createView(),
            'type' => 'edit'
            ]);
    }

    public function tableauDelete($id, TableauRepository $repo)
    {
        $repo->deleteLigneTableau($id);
        return $this->redirectToRoute('tableau_list');
    }
}
