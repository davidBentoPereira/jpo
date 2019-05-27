<?php

namespace App\Controller\admin;

use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\Survey;
use App\Form\QuestionType;
use App\Form\SurveyType;
use App\Repository\EventRepository;
use App\Repository\QuestionOptionRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuestionTypeRepository;
use App\Repository\SurveyRepository;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
                $questionType = $data['questionType'];
                $question = new Question($title);
                $question->setQuestionType($questionType);
                $question->setSurvey($survey);
                $entityManager->persist($question);
                $entityManager->flush();

                if(isset($_POST['options']))
                {
                    foreach ($_POST['options'] as $option) {
                        if(!is_null($option) && isset($option) && $option != '')
                        {
                            $newOption = new QuestionOption($option);
                            $newOption->setQuestion($question);
                            $entityManager->persist($newOption);
                            $entityManager->flush();
                        }
                    }
                }
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

        if ($form->isSubmitted()) {
            if($request->getMethod() == 'POST')
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $form->getData();/*var_dump($data);die();*/
                $title = $data['title'];
                $questionType = $data['questionType'];
                $questionOptions = $question->getQuestionOptions();

                foreach ($questionOptions as $realOption)
                {
                    $id = $realOption->getId();
                    if(isset($_POST['option-'.$id]))
                    {
                        $realOption->setValue($_POST['option-'.$id]);
                    }
                }
                if(isset($_POST['options']))
                {
                    foreach ($_POST['options'] as $option) {
                        if(!is_null($option) && isset($option) && $option != '')
                        {
                            $newOption = new QuestionOption($option);
                            $newOption->setQuestion($question);
                            $entityManager->persist($newOption);
                            $entityManager->flush();
                        }
                    }
                }

                if($questionType->getLabel() == 'Simple Text' || $questionType->getLabel() == 'Textarea')
                {
                    foreach ($questionOptions as $option)
                    {
                        $entityManager->remove($option);
                        $entityManager->flush();
                    }
                }
                $question->setQuestionType($questionType);
                $question->setTitle($title);
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

    public function deleteChoice($idChoice, $idSurvey,$idQuestion, QuestionOptionRepository $questionOptionRepository, QuestionRepository $questionRepository, SurveyRepository $surveyRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $survey = $surveyRepository->findOneBy(['id' => $idSurvey]);
        $question = $questionRepository->findOneBy(['id' => $idQuestion]);
        $choice = $questionOptionRepository->findOneBy(['id'=>$idChoice]);
        $entityManager->remove($choice);
        $entityManager->flush();
        return $this->redirectToRoute('editQuestion', ['idSurvey'=>$idSurvey, 'idQuestion'=>$idQuestion]);
    }

    public function resultExport($id, SurveyRepository $surveyRepository, $question, QuestionRepository $questionRepository)
    {
        $question = $questionRepository->findOneBy(['id' => $question]);
        $survey = $surveyRepository->findOneBy(['id' => $id]);


        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1',  'Sondage : ' . $survey->getTitle());
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2',  'Question : ' . $question->getTitle());

        $i = 3;
        foreach ($question->getResponses() as $response)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $response->getValue());

            $i++;
        }

        $cell_st =[
            'font' =>['bold' => true],
            'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:A2')->applyFromArray($cell_st);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(150);
        $spreadsheet->getActiveSheet()->setTitle(substr($survey->getTitle(),0,30));
        $spreadsheet->getActiveSheet()->getStyle('A1:A20000')
            ->getAlignment()->setWrapText(true);

        $writer = new Xlsx($spreadsheet);
        $fxls ='resultOne.xlsx';
        $writer->save($fxls);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Resultat_'.$survey->getTitle().'_'.$question->getTitle().'.xlsx"');
        header('Content-Length: ' . filesize($fxls));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        readfile( $fxls);

        /*$writer->save("php://output");*/

        return $this->render('admin/resultSurvey.html.twig',
            ['survey' => $survey]);
    }

    public function resultExportAll($id, SurveyRepository $surveyRepository)
    {
        $survey = $surveyRepository->findOneBy(['id' => $id]);
        $questions = $survey->getQuestions();

        $spreadsheet = new Spreadsheet();

        $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','K', 'L', 'M', 'N', 'O','P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z'];

        $a = 0;
        foreach ($questions as $question)
        {
            $lettre = $alphabet[$a];
            $i = 2;
            $iopt = 2;

            $spreadsheet->setActiveSheetIndex(0)->setCellValue($lettre.'1',  $question->getTitle());

            if(sizeof($question->getResponses()) > 0)
            {
                foreach ($question->getResponses() as $response)
                {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($lettre . $i, $response->getValue());
                    $spreadsheet->getActiveSheet()->getColumnDimension($lettre)->setWidth(70);
                    $i++;
                }
            }
            if(sizeof($question->getQuestionOptions()) > 0) {
                foreach ($question->getQuestionOptions() as $option)
                {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($lettre . $iopt, $option->getValue() . ' = ' . round($option->getPourcentage(),2) . '%');
                    $spreadsheet->getActiveSheet()->getColumnDimension($lettre)->setWidth(30);
                    $iopt++;
                }
            }
            $a++;
        }
        $cell_st =[
            'font' =>['bold' => true],
            'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
        ];

        $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($cell_st);
        $spreadsheet->getActiveSheet()->setTitle(substr($survey->getTitle(),0,30));
        $spreadsheet->getActiveSheet()->getStyle('A1:Z50')->getAlignment()->setWrapText(true);

        $writer = new Xlsx($spreadsheet);
        $fxls ='resultAll.xlsx';
        $writer->save($fxls);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Resultat_'.$survey->getTitle().'.xlsx"');
        header('Content-Length: ' . filesize($fxls));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        readfile( $fxls);
        /*$writer->save("php://output");*/

        return $this->render('admin/resultSurvey.html.twig',
            ['survey' => $survey]);
    }
}
