<?php

namespace App\Controller\admin;

use App\Entity\Survey;
use App\Form\SurveyType;
use App\Repository\EventRepository;
use App\Repository\SurveyRepository;
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

    public function addSurvey(Request $request, EventRepository $eventRepository)
    {
        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($request->getMethod() == 'POST')
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $form->getData();
                $title = $data['title'];
                $idEvent = $data['event'];
                $survey = new Survey($title);
                $survey->setEvent($eventRepository->findOneBy(['id' => $idEvent]));
                $entityManager->persist($survey);
                $entityManager->flush();
            }
            return $this->redirectToRoute('survey');
        }

        return $this->render('admin/formSurvey.html.twig',
            ['form' => $form->createView(),
                'type' => 'add']);
    }

    public function editSurvey($id, Request $request, SurveyRepository $surveyRepository, EventRepository $eventRepository)
    {
        $survey = $surveyRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($request->getMethod() == 'POST')
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $form->getData();;
                $title = $data['title'];
                $idEvent = $data['event'];
                $survey->setTitle($title);
                $survey->setEvent($eventRepository->findOneBy(['id' => $idEvent]));
                $entityManager->persist($survey);
                $entityManager->flush();
            }
            return $this->redirectToRoute('survey');
        }

        return $this->render('admin/formSurvey.html.twig',
            ['form' => $form->createView(),
                'type' => 'edit',
                'survey' => $survey]);
    }

    public function deleteSurvey($id,  SurveyRepository $surveyRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $survey = $surveyRepository->findOneBy(['id' => $id]);
        $entityManager->remove($survey);
        $entityManager->flush();
        return $this->redirectToRoute('survey');
    }

    public function resultSurvey($id,  SurveyRepository $surveyRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $survey = $surveyRepository->findOneBy(['id' => $id]);

        return $this->render('admin/resultSurvey.html.twig',
            ['survey' => $survey]);
    }
}
