<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Admin;
use App\Entity\Page;
use App\Entity\Filiere;
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
         * Génération des fixtures des pages filière
         */
        $filiere = new Filiere();
        $filiere->setTitle("3ème PREPA MÉTIERS");
        $filiere->setCandidate("Admission après la classe de 4ème -   La candidature doit être déposée auprès du collège.");
        $filiere->setDescription("<p>La classe 3PREPA-PRO concerne un public de coll&eacute;giens pr&ecirc;t &agrave; se mobiliser autour d&rsquo;un projet de formation dans la voie professionnelle.</p><p>L&rsquo;&eacute;l&egrave;ve est dans une classe unique de 3&egrave;me &agrave; dispositif particulier, int&eacute;gr&eacute;e au lyc&eacute;e et pr&eacute;sente le dipl&ocirc;me national du &nbsp;brevet des coll&egrave;ges &lsquo;&rsquo;s&eacute;rie professionnelle&rsquo;&rsquo;.</p>");
        
        $filiere->setTitleBlock1("Objectifs");
        $filiere->setTextBlock1("<ul>
                                    <li>Remotiver l&rsquo;&eacute;l&egrave;ve.</li>
                                    <li>R&eacute;ussir son orientation en d&eacute;veloppant des connaissances et comp&eacute;tences, en explorant diff&eacute;rents secteurs professionnels (production, et services &agrave; la personne et &agrave; l&rsquo; entreprise).</li>
                                    <li>Obtenir le Dipl&ocirc;me National du Brevet (s&eacute;rie professionnelle)</li>
                                </ul>");
        
        $filiere->setTitleBlock2("Compétences développées");
        $filiere->setTextBlock2("<p>Apporter une connaissance du monde professionnel</p>
        <p>Apprendre &agrave; mieux se conna&icirc;tre</p>
        <p>Explorer les diff&eacute;rents secteurs professionnels</p>
        <p>Conna&icirc;tre les diff&eacute;rentes modalit&eacute;s de la pr&eacute;paration des dipl&ocirc;mes professionnels (en formation initiale, en alternance)</p>");
        
        $filiere->setTitleBlock3("Les découvertes en milieu professionnel");
        $filiere->setTextBlock3("<p>3 p&eacute;riodes obligatoires de d&eacute;couverte professionnelle en entreprise d&rsquo;une semaine r&eacute;parties sur l&rsquo;ann&eacute;e.</p>");
        
        $filiere->setTitleBlock4("Lorem Ipsum standard");
        $filiere->setTextBlock4("<p>&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;</p>");

        $filiere->setTitleBlock5("Poursuite d’étude");
        $filiere->setTextBlock5("<p>CAP</p><p>BAC PROFESSIONNEL</p>");

        $filiere->setColorPicker("#ffffff");

        $manager->persist($filiere);


        /**
         * Génération des fixtures des types de question
         */
        $simpleTextQuestionType = new QuestionType('Simple Text');
        $simpleTextQuestionType->setResume('Un champs de saisie de texte sur une ligne.');
        $manager->persist($simpleTextQuestionType);

        
        $textareaTextQuestionType = new QuestionType('Textarea');
        $textareaTextQuestionType->setResume('Un champs de saisie de texte sur plusieurs lignes possibles.');
        $manager->persist($textareaTextQuestionType);
        

        $simpleChoiceQuestionType = new QuestionType('Simple Choice');
        $simpleChoiceQuestionType->setResume('Un choix multiple à une seule réponse possible.');
        $manager->persist($simpleChoiceQuestionType);


        $multipleChoiceQuestionType = new QuestionType('Multiple Choice');
        $multipleChoiceQuestionType->setResume('Un choix multiple à plusieurs réponses possibles.');
        $manager->persist($multipleChoiceQuestionType);


        /**
         * Génération des fixtures des évènements
         */
        for($i = 1; $i < 7; ++$i)
        {
            $dateOfOpening = new \DateTimeImmutable();
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
