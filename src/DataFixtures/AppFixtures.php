<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Admin;
use App\Entity\Page;
use App\Entity\Section;
use App\Entity\Event;
use App\Entity\Survey;
use App\Entity\Question;
use App\Entity\QuestionType;
use App\Entity\QuestionOption;
use App\Entity\Response;
use App\Entity\ResponseValue;
use App\Service\EncryptingService;
use App\Service\SlugGeneratorService;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /**
         * Les fixtures suivantes sont à utiliser en dévelopement.
         * Il est fortement déconseillé de les appliquer sur la base de données en production.
         */


        /**
         * Génération des fixtures de l'admin test
        * Mail : test@example.com
        * Mot de passe : test
        */
        $admin = new Admin();
        $admin->setEmail("test@example.com");
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin, "test"
        ));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        /**
         * Génération des fixtures des pages formations
         */
        /*for($i = 1; $i < 7; ++$i)
        {
            $sections = [];
            $page = new Page("Page ".$i);
            for($j = 1; $j < 7; ++$j)
            {
                $section = new Section($j, "Title ".$j, "Description ".$j);
                $page->addSection($section);
            }
            $manager->persist($page);
        }*/


        /**
         * Génération des fixtures des types de question
         */
        $simpleTextQuestionType = new QuestionType('Simple Text');
        $manager->persist($simpleTextQuestionType);

        
        $textareaTextQuestionType = new QuestionType('Textarea');
        $manager->persist($textareaTextQuestionType);
        

        $simpleChoiceQuestionType = new QuestionType('Simple Choice');
        $manager->persist($simpleChoiceQuestionType);


        $multipleChoiceQuestionType = new QuestionType('Multiple Choice');
        $manager->persist($multipleChoiceQuestionType);


        /**
         * Génération des fixtures des évènements
         */
        for($i = 1; $i < 7; ++$i)
        {
            $dateOfOpening = new \DateTimeImmutable("2019-01-01 08:00:01");
            $dateOfClosure = $dateOfOpening->add(new \DateInterval("P7M3D"));
            $event = new Event("Event ".$i, $dateOfOpening, $dateOfClosure);
            for($j = 0; $j < 2; ++$j)
            {

                /**
                 * Génération des fixtures des sondages
                 */
                $survey = new Survey("Sondage ".$j);

                
                /**
                 * Génération des fixtures des questions
                 */
                $question = new Question("Question 1");
                $question->setQuestionType($simpleTextQuestionType);
                /**
                 * Génération des fixtures des réponses pour la question précédente
                 */
                $reponse = new Response();
                $responseValue = new ResponseValue("Valeur renseignée");
                $reponse->addResponseValue($responseValue);
                $question->addResponse($reponse);
                $survey->addQuestion($question);


                $question = new Question("Question 2");
                $question->setQuestionType($textareaTextQuestionType);
                $survey->addQuestion($question);

                /**
                 * Dans les cas de questions à choix,
                 * On génère les fixtures pour les options à ces questions 
                 */
                $question = new Question("Question 3");
                $question->setQuestionType($simpleChoiceQuestionType);
                
                $questionOption = new QuestionOption("Option 1");
                $question->addQuestionOption($questionOption);
                
                $questionOption = new QuestionOption("Option 2");
                $question->addQuestionOption($questionOption);
                
                $survey->addQuestion($question);
                

                $question = new Question("Question 4");
                $question->setQuestionType($multipleChoiceQuestionType);
                
                $questionOption = new QuestionOption("Option 1");
                $question->addQuestionOption($questionOption);
                
                $questionOption = new QuestionOption("Option 2");
                $question->addQuestionOption($questionOption);
                
                $survey->addQuestion($question);

                $event->addSurvey($survey);
            }

            $manager->persist($event);
        }

        $manager->flush();
    }
}
