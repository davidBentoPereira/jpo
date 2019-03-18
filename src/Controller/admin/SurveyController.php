<?php

namespace App\Controller\admin;

use App\Entity\Survey;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SurveyController extends AbstractController
{
    public function survey()
    {
        $repository = $this->getDoctrine()->getRepository(Survey::class);
        $surveys = $repository->findAll();
        return $this->render('admin/survey.html.twig',
            ["surveys" => $surveys]);
    }

    public function addSurvey()
    {

    }
}
