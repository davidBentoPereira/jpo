<?php

namespace App\Controller;

use App\Repository\QuestionOptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\FiliereRepository;
use App\Repository\EventRepository;
use App\Repository\SurveyRepository;
use App\Repository\QuestionRepository;
use App\Repository\TableauRepository;

class FrontController extends AbstractController
{
    public function index(FiliereRepository $repo): Response
    {
        return $this->render('front/index.html.twig', ['dispositifs' => $repo->findAllLinksDispositifsSpeciaux()]);
    }

    public function formations(TableauRepository $tableauRepo): Response
    {
        return $this->render('front/formations.html.twig', ['tableau' => $tableauRepo->findAllLinesInTableSortedByAlphabetOrder()]);
    }

    public function filiere($id, $title, FiliereRepository $repo): Response
    {
        return $this->render('front/filiere-et-dispositifs.html.twig', ['filiere' => $repo->find($id)]);
    }

    public function sondages(EventRepository $eventRepo, SurveyRepository $surveyRepo): Response
    {
        return $this->render('front/sondages.html.twig', [
            'events' => $eventRepo->findAllEventOnGoing(),
            'surveys' => $surveyRepo->findAll()
        ]);
    }

    public function sondage(Request $request, QuestionRepository $questionRep, QuestionOptionRepository $questionOptionRepository, SurveyRepository $surveyRepository, $id): Response
    {
        $survey =  $surveyRepository->findOneBy(['id' => $id]);
        $questions = $survey->getQuestions();

        if($request->getMethod() == 'POST')
        {
            $entityManager = $this->getDoctrine()->getManager();
            foreach($questions as $question)
            {
                if(isset($_POST['question-'.$question->getId()]))
                {
                    $response = $_POST['question-'.$question->getId()];
                    $realResponse = new \App\Entity\Response();
                    if(gettype($response) == 'string')
                    {
                        if(isset($response) && !empty($response))
                        {
                            $realResponse->setValue($response);
                            $realResponse->setQuestion($question);
                        }
                    } else  {
                        foreach($response as $option)
                        {
                            $realResponse->setQuestion($question);
                            $questionOption = $questionOptionRepository->findOneBy(['id' => $option]);
                            $questionOption->addResponse($realResponse);
                        }
                    }
                    $entityManager->persist($realResponse);
                    $entityManager->flush();
                }
            }

            return $this->render('front/sondage.html.twig',[
                'survey' => $survey,
                'submitted' => 'OK'
            ]);
        }

        return $this->render('front/sondage.html.twig',[
            'survey' => $survey
        ]);
    }

    public function histoire(): Response
    {
        return $this->render('front/histoire.html.twig');
    }

    public function planDuLycee(): Response
    {
        return $this->render('front/plan-du-lycee.html.twig');
    }

    public function navbarListFiliere(FiliereRepository $repo): Response
    {
        return $this->render('front/base/nav.html.twig', ['listFilieres' => $repo->findAllFilieresSortedByAlphabetOrder()]);
    }

}