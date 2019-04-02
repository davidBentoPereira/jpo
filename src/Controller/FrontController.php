<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\FiliereRepository;
use App\Repository\EventRepository;
use App\Repository\SurveyRepository;
use App\Repository\QuestionRepository;

class FrontController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }

    public function formations(): Response
    {
        return $this->render('front/formations.html.twig');
    }

    public function filiere($id, $title, FiliereRepository $repo): Response
    {
        return $this->render('front/filiere.html.twig', ['filiere' => $repo->find($id)]);
    }

    public function ulis(): Response
    {
        return $this->render('front/ulis.html.twig');
    }

    public function mlds(): Response
    {
        return $this->render('front/mlds.html.twig');
    }

    public function sondages(EventRepository $eventRepo, SurveyRepository $surveyRepo): Response
    {
        return $this->render('front/sondages.html.twig', [
            'events' => $eventRepo->findAll(),
            'surveys' => $surveyRepo->findAll()
        ]);
    }

    public function sondage(SurveyRepository $surveyRepo, QuestionRepository $questionRep, $id): Response
    {
        $questions = $surveyRepo->findSurveyById($id)->getQuestions()->getValues();
        $questions2 = $questionRep->findAll();
        return $this->render('front/sondage.html.twig',[
            'survey' => $surveyRepo->findSurveyById($id),
            'questions' => $questions,
            'questions2' => $questions2,
        ]);
    }

    public function histoire(): Response
    {
        return $this->render('front/histoire.html.twig');
    }

    public function navbarListFiliere(FiliereRepository $repo): Response
    {
        return $this->render('front/base/nav.html.twig', ['listFilieres' => $repo->findAllFilieresSortedByRank()]);
    }

}