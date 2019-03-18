<?php

namespace App\Controller\admin;

use App\Entity\Survey;
use App\Form\SurveyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SurveyController extends AbstractController
{
    public function survey()
    {
        $repository = $this->getDoctrine()->getRepository(Survey::class);
        $surveys = $repository->findAll();
        return $this->render('admin/survey.html.twig',
            ["surveys" => $surveys]);
    }

    public function addSurvey(Request $request)
    {
        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('survey');
        }

        return $this->render('admin/formSurvey.html.twig',
            ['form' => $form->createView(),
                'type' => 'add']);
    }

    public function editSurvey(Request $request)
    {
        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('survey');
        }

        return $this->render('admin/formSurvey.html.twig',
            ['form' => $form->createView(),
                'type' => 'edit']);
    }

    public function deleteSurvey()
    {
        return $this->render('admin/survey.html.twig');
    }
}
