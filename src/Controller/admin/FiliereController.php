<?php

namespace App\Controller\admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FiliereRepository;
use App\Entity\Filiere;
use App\Form\FiliereType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FiliereController extends AbstractController
{
    public function filiereList(FiliereRepository $repo): Response
    {
        return $this->render('admin/filiere_list.html.twig', ['filieres' => $repo->findAllFilieresSortedByRank()]);
    }

    public function filiereAdd(Request $request, EntityManagerInterface $em): Response
    {
        $filiere = new Filiere;
        $filiereForm = $this->createForm(FiliereType::class, $filiere);

        $filiereForm->handleRequest($request);

        if ($filiereForm->isSubmitted() && $filiereForm->isValid())
        {
            $em->persist($filiereForm->getData());
            $em->flush();

            $this->addFlash('success', 'La nouvelle filière a bien été ajouté.');

            return $this->redirectToRoute('filiere_add');
        }

        return $this->render('admin/filiere_add_or_edit.html.twig', [
            'pageForm' => $filiereForm->createView(),
            'type' => 'add',
            ]);
    }

    public function filiereEdit(Request $request, EntityManagerInterface $em, FiliereRepository $repo, $id): Response
    {
        $filiere = $repo->find($id);
        $filiereForm = $this->createForm(FiliereType::class, $filiere);
        $filiereForm->handleRequest($request);

        if ($filiereForm->isSubmitted() && $filiereForm->isValid())
        {
            $em->persist($filiereForm->getData());
            $em->flush();
            $this->addFlash('success', 'La filière a bien été modifié.');

            return $this->redirectToRoute('filiere_edit', ['id' => $id]);
        }

        return $this->render('admin/filiere_add_or_edit.html.twig', [
            'pageForm' => $filiereForm->createView(),
            'type' => 'edit'
        ]);
    }

    public function filiereDelete($id, FiliereRepository $repo)
    {
        $repo->deleteFiliere($id);
        return $this->redirectToRoute('filiere_list');
    }
}
