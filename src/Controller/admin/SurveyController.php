<?php

namespace App\Controller\admin;

use App\Entity\Question;
use App\Entity\Survey;
use App\Form\QuestionType;
use App\Form\SurveyType;
use App\Repository\EventRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuestionTypeRepository;
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

    /*---- QUESTIONS -----*/

    public function addQuestion($id, Request $request, QuestionRepository $questionRepository, SurveyRepository $surveyRepository, QuestionTypeRepository $questionTypeRepository)
    {
        $survey = $surveyRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(QuestionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($request->getMethod() == 'POST')
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $form->getData();
                $title = $data['title'];
                $idQuestionType = $data['questionType'];
                $question = new Question($title);
                $question->setQuestionType($questionTypeRepository->findOneBy(['id' => $idQuestionType]));
                $question->setSurvey($survey);
                $entityManager->persist($question);
                $entityManager->flush();
            }
            return $this->redirectToRoute('editSurvey', ['id'=>$id]);
        }

        return $this->render('admin/formQuestion.html.twig',
            ['form' => $form->createView(),
                'type' => 'add',
                'survey' => $survey]);
    }

    public function editQuestion($idSurvey, $idQuestion, Request $request, QuestionRepository $questionRepository, SurveyRepository $surveyRepository, QuestionTypeRepository $questionTypeRepository)
    {
        $survey = $surveyRepository->findOneBy(['id' => $idSurvey]);
        $question = $questionRepository->findOneBy(['id' => $idQuestion]);
        $form = $this->createForm(QuestionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($request->getMethod() == 'POST')
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $form->getData();
                $title = $data['title'];
                $idQuestionType = $data['questionType'];
                $question->setTitle($title);
                $question->setQuestionType($questionTypeRepository->findOneBy(['id' => $idQuestionType]));
                $question->setSurvey($survey);
                $entityManager->persist($question);
                $entityManager->flush();
            }
            return $this->redirectToRoute('editSurvey', ['id'=>$idSurvey]);
        }

        return $this->render('admin/formQuestion.html.twig',
            ['form' => $form->createView(),
                'type' => 'edit',
                'question' => $question,
                'survey' => $survey]);
    }

    public function deleteQuestion($id, $idQuestion, QuestionRepository $questionRepository, SurveyRepository $surveyRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $survey = $surveyRepository->findOneBy(['id' => $id]);
        $question = $questionRepository->findOneBy(['id' => $idQuestion]);
        $entityManager->remove($question);
        $entityManager->flush();
        return $this->redirectToRoute('editSurvey', ['id'=>$id]);
    }
}
