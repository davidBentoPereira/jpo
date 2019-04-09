<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Admin;
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
        
        // 1. 3ème PREPA MÉTIERS
        $filiere1 = new Filiere();
        $filiere1->setTitle("3ème PREPA MÉTIERS");
        $filiere1->setCandidate("Admission après la classe de 4ème -   La candidature doit être déposée auprès du collège.");
        $filiere1->setDescription("<p>La classe 3PREPA-PRO concerne un public de coll&eacute;giens pr&ecirc;t &agrave; se mobiliser autour d&rsquo;un projet de formation dans la voie professionnelle.</p><p>L&rsquo;&eacute;l&egrave;ve est dans une classe unique de 3&egrave;me &agrave; dispositif particulier, int&eacute;gr&eacute;e au lyc&eacute;e et pr&eacute;sente le dipl&ocirc;me national du &nbsp;brevet des coll&egrave;ges &lsquo;&rsquo;s&eacute;rie professionnelle&rsquo;&rsquo;.</p>");
        $filiere1->setTitleBlock1("Objectifs");
        $filiere1->setTextBlock1("<ul><li>Remotiver l&rsquo;&eacute;l&egrave;ve.</li><li>R&eacute;ussir son orientation en d&eacute;veloppant des connaissances et comp&eacute;tences, en explorant diff&eacute;rents secteurs professionnels (production, et services &agrave; la personne et &agrave; l&rsquo; entreprise).</li><li>Obtenir le Dipl&ocirc;me National du Brevet (s&eacute;rie professionnelle)</li></ul>");
        $filiere1->setTitleBlock2("Compétences développées");
        $filiere1->setTextBlock2("<p>Apporter une connaissance du monde professionnel</p>
        <p>Apprendre &agrave; mieux se conna&icirc;tre</p>
        <p>Explorer les diff&eacute;rents secteurs professionnels</p>
        <p>Conna&icirc;tre les diff&eacute;rentes modalit&eacute;s de la pr&eacute;paration des dipl&ocirc;mes professionnels (en formation initiale, en alternance)</p>");
        $filiere1->setTitleBlock3("Les découvertes en milieu professionnel");
        $filiere1->setTextBlock3("<p>3 p&eacute;riodes obligatoires de d&eacute;couverte professionnelle en entreprise d&rsquo;une semaine r&eacute;parties sur l&rsquo;ann&eacute;e.</p>");
        $filiere1->setTitleBlock4("Lorem Ipsum standard");
        $filiere1->setTextBlock4("<p>&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;</p>");
        $filiere1->setTitleBlock5("Poursuite d’étude");
        $filiere1->setTextBlock5("<p>CAP</p><p>BAC PROFESSIONNEL</p>");
        $filiere1->setColorPicker("#ffffff");
        $manager->persist($filiere1);

        // 2. Accueil Relations Clientèle Usager
        $filiere2 = new Filiere();
        $filiere2->setTitle("Accueil Relations Clientèle Usager");
        $filiere2->setCandidate("Admission après la classe de 3ème -  La candidature s’effectue par la procédure AFFELNET dans l’établissement d’origine.");
        $filiere2->setDescription("<p>Le titulaire du Bac pro ARCU accueille les clients ou les usagers en face &agrave; face ou par t&eacute;l&eacute;phone et assure la prise en charge de leurs demandes ou r&eacute;clamations&nbsp;; conseille, informe et assiste le client ou l&rsquo;usager&nbsp;; propose et r&eacute;alise des ventes de services&nbsp;; exerce ses activit&eacute;s dans les entreprises de services aux particuliers ou aux entreprises (agences de tourisme, soci&eacute;t&eacute; de location, compagnies a&eacute;rienne, maritime et ferroviaire, organismes de cr&eacute;dit et assurances, centres de loisirs&hellip;), dans les services d&rsquo;information et de production, les administrations, les SAV d&rsquo;entreprises, mairies, h&ocirc;tels de r&eacute;gion, h&ocirc;pitaux&hellip;.</p>");
        $filiere2->setTitleBlock1("Qualités requises");
        $filiere2->setTextBlock1("<ul><li>Etre &agrave; l&rsquo;&eacute;coute</li><li>Rigoureux</li><li>Dynamique</li><li>Pr&eacute;sentation soign&eacute;e</li><li>Contact ais&eacute;</li></ul>");
        $filiere2->setTitleBlock2("Compétences développées");
        $filiere2->setTextBlock2("<p>Capacit&eacute; &agrave; r&eacute;pondre aux demandes en face &agrave; face ou par t&eacute;l&eacute;phone, d&eacute;veloppement du sens de l&rsquo;&eacute;coute, &eacute;valuation de la satisfaction de l&rsquo;interlocuteur, comp&eacute;tences commerciales&nbsp;: savoir vendre des services, assurer le d&eacute;marchage, traiter la mise &agrave; jour de fichiers prospects, &eacute;tablir des factures et encaisser.</p>");
        $filiere2->setTitleBlock3("Les formations en entreprise");
        $filiere2->setTextBlock3("<p>22 semaines de stage en entreprise r&eacute;parties sur 3 ans que dure la formation&nbsp;: h&ocirc;tel, centre m&eacute;dical, mairie, administrations, agence int&eacute;rim, organisme culturel, entreprise.</p>");
        $filiere2->setTitleBlock4("Vie active");
        $filiere2->setTextBlock4("<ul><li>H&ocirc;te/H&ocirc;tesse d&rsquo;accueil / de caisse / en agence &eacute;v&eacute;nementielle</li><li>Charg&eacute;(e) de l&rsquo;accueil</li><li>Standardiste</li></ul>");
        $filiere2->setTitleBlock5("Poursuite d’étude");
        $filiere2->setTextBlock5("<ul><li>Mention compl&eacute;mentaire Accueil dans les transports&nbsp;: Agent d&rsquo;escale en a&eacute;roport ou dans une soci&eacute;t&eacute; a&eacute;roportuaire</li><li>Mention compl&eacute;mentaire Accueil r&eacute;ception&nbsp;: r&eacute;ceptionniste dans les &eacute;tablissements d&rsquo;h&eacute;bergement (h&ocirc;tel, r&eacute;sidence m&eacute;dicalis&eacute;e, centre de loisirs&hellip;)</li><li>BTS Tourisme&nbsp;: production de vente de voyages et s&eacute;jours pour des clients fran&ccedil;ais et &eacute;trangers</li>\r\n\t<li>BTS Assistant(e) &nbsp;de gestion&nbsp; PME &ndash; PMI&nbsp;: assistant(e) commercial(e), secr&eacute;taire</li></ul>");
        $manager->persist($filiere2);

        // 3. Accompagnement, Soins, Services à la Personne (ASSP)  OPTION STRUCTURE
        $filiere3 = new Filiere();
        $filiere3->setCandidate("Admission après la classe de 3ème -  La candidature s’effectue par la procédure AFFELNET dans l’établissement d’origine.");
        $filiere3->setDescription("<p style=\"margin-right:12px\">Le titulaire du Bac pro ASSP peut exercer ses fonctions aupr&egrave;s de personnes en situation temporaire ou permanente de d&eacute;pendance (enfants, personnes en situation de handicap, personnes &acirc;g&eacute;es,...). Il exerce des activit&eacute;s de soins d&rsquo;hygi&egrave;ne et de confort, d&rsquo;aide aux actes de la vie quotidienne, de maintien de la vie sociale, en structures collectives.</p>\r\n\r\n<p>Le titulaire du Bac pro ASSP est <strong>surtout amen&eacute; &agrave; poursuivre des &eacute;tudes</strong> dans le secteur</p>");
        $filiere3->setTextBlock1("<ul>\r\n\t<li>Respect d&rsquo;autrui</li>\r\n\t<li>Ponctualit&eacute;, assiduit&eacute;</li>\r\n\t<li>Patience, &eacute;coute, bienveillance</li>\r\n\t<li>Sens du travail en &eacute;quipe</li>\r\n\t<li>R&eacute;sistance physique et nerveuse</li>\r\n\t<li>Discr&eacute;tion</li>\r\n</ul>");
        $filiere3->setTextBlock2("<p>R&eacute;alisation de soins d&rsquo;hygi&egrave;ne, de confort, surveillance de l&rsquo;&eacute;tat de sant&eacute;&nbsp;; mise en &oelig;uvre d&rsquo;activit&eacute;s d&rsquo;aide au maintien de l&rsquo;autonomie et de la vie sociale, pr&eacute;paration et service des collations et repas, entretien de l&rsquo;environnement de la personne</p>");
        $filiere3->setTextBlock3("<p>22 semaines de stage en entreprise r&eacute;parties sur 3 ans : 10 semaines en &eacute;cole maternelle, en centre de loisir, en secteur petite enfance et <strong>obligatoirement 12 semaines en h&eacute;bergement pour personnes &acirc;g&eacute;es.</strong></p>");
        $filiere3->setTextBlock4("<p>Travail aupr&egrave;s des personnes, enfants et adultes, des personnes &acirc;g&eacute;es, malades ou handicap&eacute;es.</p>");
        $filiere3->setTextBlock5("<ul>\r\n\t<li>BTS Economie Sociale et Familiale (expert des domaines de la vie quotidienne&nbsp;: alimentation-sant&eacute;, budget, consommation, habitat logement, environnement/&eacute;nergie).</li>\r\n\t<li>BTS Services et Prestations des Secteurs Sanitaire et Social&nbsp;(exerce dans des services de mutuelles, structures de soins, centres d&rsquo;action sociale, service de protection de la jeunesse&hellip;)</li>\r\n\t<li>Equivalence d&rsquo;une partie du dipl&ocirc;me d&rsquo;aide-soignant, d&rsquo;auxiliaire de pu&eacute;riculture, moniteur-&eacute;ducateur apr&egrave;s r&eacute;ussite au concours d&rsquo;entr&eacute;e</li>\r\n\t<li>Concours d&rsquo;entr&eacute;e&nbsp;: Dipl&ocirc;me d&rsquo;&Eacute;tat d&rsquo;Accompagnant &Eacute;ducatif et Social<strong> -</strong> infirmier &ndash; &eacute;ducateur de jeunes enfants &ndash; &eacute;ducateur sp&eacute;cialis&eacute;</li>\r\n</ul>");
        $filiere3->setTitle("Accompagnement, Soins, Services à la Personne (ASSP)  OPTION STRUCTURE");
        $filiere3->setTitleBlock1("Qualités requises");
        $filiere3->setTitleBlock2("Compétences développées");
        $filiere3->setTitleBlock3("Les formations en entreprise");
        $filiere3->setTitleBlock4("Vie active");
        $filiere3->setTitleBlock5("Poursuite d’étude");
        $manager->persist($filiere3);

        // 4. Commerce
        $filiere4 = new Filiere();
        $filiere4->setCandidate("Admission après la classe de 3ème -  La candidature s’effectue par la procédure AFFELNET dans l’établissement d’origine.");
        $filiere4->setDescription("<p>Le titulaire du Bac pro Commerce intervient dans des unit&eacute;s commerciales afin de proposer aux clients les produits qu&rsquo;ils recherchent. Il peut &ecirc;tre employ&eacute; commercial, assistant de vente, conseiller de vente, vendeur technique, manager.</p>");
        $filiere4->setTextBlock1("<ul>\r\n\t<li>Organis&eacute;</li>\r\n\t<li>Rigoureux</li>\r\n\t<li>Dynamique</li>\r\n\t<li>Sens du relationnel</li>\r\n\t<li>Pr&eacute;sentation soign&eacute;e</li>\r\n</ul>");
        $filiere4->setTextBlock2("<ul>\r\n\t<li>D&eacute;velopper l&rsquo;esprit de vente</li>\r\n\t<li>Enrichir son esprit d&rsquo;initiative</li>\r\n\t<li>Devenir un animateur de son point de vente et de son &eacute;quipe</li>\r\n\t<li>Exercer en temps qu&rsquo;adjoint ou responsable de tout ou partie d&rsquo;un magasin, supermarch&eacute;, hypermarch&eacute;, agence commerciale, site marchand&hellip;</li>\r\n</ul>");
        $filiere4->setTextBlock3("<p>22 semaines de stage en entreprise, r&eacute;parties sur 3 ans que dure la formation, dans des boutiques, centres commerciaux</p>");
        $filiere4->setTextBlock4("<p>Vend(eur/euse) en magasin, Vendeur sp&eacute;cialis&eacute;, vendeur conseil&hellip;</p>\r\n\r\n<p>Adjoint d&rsquo;un commer&ccedil;ant ou d&rsquo;un responsable de magasin, ou du chef de rayon</p>\r\n\r\n<p>Responsable de rayon ou d&rsquo;un stand</p>\r\n\r\n<p>T&eacute;l&eacute;vend(eur/euse)</p>");
        $filiere4->setTextBlock5("<ul>\r\n\t<li>Mention compl&eacute;mentaire vendeur sp&eacute;cialis&eacute; en alimentation</li>\r\n\t<li>Formation continue d&rsquo;initiative locale Vendeur de produits multimedia</li>\r\n\t<li>Mention compl&eacute;mentaire Assistance, conseil, vente &agrave; distance</li>\r\n\t<li>BTS Management des unit&eacute;s commerciales&nbsp;:attach&eacute;(e) commercial(e), conseiller(e) en voyages, courtier(e), chef(e) des ventes&nbsp;; agent g&eacute;n&eacute;ral d&rsquo;assurances&nbsp;</li>\r\n\t<li>BTS N&eacute;gociation et relation client&nbsp;: charg&eacute;(e) de client&egrave;le banque, gestionnaire en contrats d&rsquo;assurance, charg&eacute;(e) d&rsquo;affaires</li>\r\n</ul>");
        $filiere4->setTitle("Commerce");
        $filiere4->setTitleBlock1("Qualités requises");
        $filiere4->setTitleBlock2("Compétences développées");
        $filiere4->setTitleBlock3("Les formations en entreprise");
        $filiere4->setTitleBlock4("Vie active");
        $filiere4->setTitleBlock5("Poursuite d’étude");
        $manager->persist($filiere4);
        
        // 5. Esthétique - Cosmétique - Parfumerie
        $filiere5 = new Filiere();
        $filiere5->setCandidate("Admission après la classe de 3ème -  La candidature s’effectue par la procédure AFFELNET dans l’établissement d’origine");
        $filiere5->setDescription("<p>Le titulaire du Bac pro Esth&eacute;tique Cosm&eacute;tique Parfumerie r&eacute;alise des&nbsp; soins esth&eacute;tiques (soins du visage et du corps, maquillage, &eacute;pilation,) et vend des services et des produits de parfumerie.</p>\r\n\r\n<p>Il intervient en Institut de beaut&eacute;, parfumerie, salon de coiffure, Spa, centre de Thalasso, Centre de vacances, loisirs, Onglerie, Solarium, milieux hospitalier et carc&eacute;ral, dans les entreprises de fabrication de produits et mat&eacute;riels</p>");
        $filiere5->setTextBlock1("<p><em>Avoir :</em></p>\r\n\r\n<ul>\r\n\t<li>. une grande r&eacute;sistance physique,</li>\r\n\t<li>une tenue et un maintien appropri&eacute; aux secteurs d&rsquo;activit&eacute;s,</li>\r\n\t<li>. une grande habilet&eacute; manuelle</li>\r\n\t<li>. le sens de la communication orale, le go&ucirc;t du management et le sens de l&rsquo;organisation</li>\r\n</ul>\r\n\r\n<p><em>Etre :</em></p>\r\n\r\n<ul>\r\n\t<li>.souriante</li>\r\n\t<li>.disponible et aimer le contact avec la client&egrave;le</li>\r\n</ul>");
        $filiere5->setTextBlock2("<p>Soins esth&eacute;tiques&nbsp;: manucure, maquillage, soin du visage, du corps et des pieds, &eacute;plations&hellip; vente de produits et de prestations de services, gestion des cabines de soins et des stocks, suivi de client&egrave;le, gestion administrative et financi&egrave;re</p>");
        $filiere5->setTextBlock3("<p>22 semaines de stage en entreprise r&eacute;parties sur 3 ans que dure la formation&nbsp;: en parfumerie, institut, SPA, parapharmacie, onglerie</p>\r\n\r\n<p>En fin de 2&egrave;me ann&eacute;e, passage du CAP Esth&eacute;tique</p>");
        $filiere5->setTextBlock4("<p>Conseill&egrave;re beaut&eacute; &ndash; Esth&eacute;ticienne &ndash; Ambassadrice de marque &ndash; Animatrice - Formatrice</p>");
        $filiere5->setTextBlock5("<p>BTS M&eacute;tiers de l&rsquo;Esth&eacute;tique Cosm&eacute;tique Parfumerie&nbsp;: Formation-marques - Cosm&eacute;tologie</p>\r\n\r\n<p>BTS Management des Unit&eacute;s commerciales&nbsp;: attach&eacute;(e) commercial(e), chef(e) de ventes</p>");
        $filiere5->setTitle("Esthétique - Cosmétique - Parfumerie");
        $filiere5->setTitleBlock1("Qualités requises");
        $filiere5->setTitleBlock2("Compétences développées");
        $filiere5->setTitleBlock3("Les formations en entreprise");
        $filiere5->setTitleBlock4("Vie active");
        $filiere5->setTitleBlock5("Poursuite d’étude");
        $manager->persist($filiere5);

        // 6. Gestion - Administration
        $filiere6 = new Filiere();
        $filiere6->setCandidate("Admission après la classe de 3ème - La candidature s’effectue par la procédure AFFELNET dans l’établissement d’origine");
        $filiere6->setDescription("<p>Le titulaire du Bac Pro Gestion Administration est appel&eacute; &agrave; travailler dans des entreprises, des collectivit&eacute;s territoriales, des administrations ou des associations.</p>\r\n\r\n<p>Il prend en charge des activit&eacute;s de communication, de gestion du personnel, de gestion commerciale, ainsi que la gestion administrative de projets.</p>");
        $filiere6->setTextBlock1("<ul>\r\n\t<li>Sens de l&rsquo;organisation</li>\r\n\t<li>Rigueur et discr&eacute;tion</li>\r\n\t<li>Esprit d&rsquo;initiatives et d&rsquo;autonomie</li>\r\n\t<li>Capacit&eacute;s r&eacute;dactionnelles</li>\r\n\t<li>Aptitudes relationnelles</li>\r\n\t<li>Int&eacute;r&ecirc;t pour les technologies de l&rsquo;information et de la communication</li>\r\n</ul>");
        $filiere6->setTextBlock2("<ul>\r\n\t<li>G&eacute;rer les relations avec les fournisseurs (commandes, livraisons, stocks&hellip;), avec les clients, les usagers et les autres partenaires</li>\r\n\t<li>Participer au recrutement du personnel</li>\r\n\t<li>G&eacute;rer la r&eacute;mun&eacute;ration et le budget du personnel</li>\r\n\t<li>Organiser la logistique administrative d&#39;une r&eacute;union</li>\r\n\t<li>Traiter le courrier, les appels t&eacute;l&eacute;phoniques</li>\r\n\t<li>G&eacute;rer les agendas&hellip;</li>\r\n</ul>");
        $filiere6->setTextBlock3("<p>22 semaines de stage en entreprise r&eacute;parties sur 3 ans :</p>\r\n\r\n<p>Dans des entreprises, associations, administrations</p>");
        $filiere6->setTextBlock4("<p>Employ&eacute; administratif, gestionnaire du personnel, gestionnaire commercial</p>");
        $filiere6->setTextBlock5("<ul>\r\n\t<li>BTS Assistant de gestion PME PMI&nbsp;: assistant(e)commercial(e) &ndash; secr&eacute;taire &ndash; assistant(e) de gestion</li>\r\n\t<li>BTS Assistant Manager&nbsp;: assistant(e) en ressources humaines &ndash; secr&eacute;taire juridique</li>\r\n\t<li>Autres BTS tertiaires</li>\r\n\t<li>BTS Comptabilit&eacute; Gestion&nbsp;: assistant(e) de gestion PME , comptable, contr&ocirc;leur(euse) de gestion</li>\r\n\t<li>BTS Banque&nbsp;: Charg&eacute;(e) de client&egrave;le banque</li>\r\n\t<li>BTS Tourisme&nbsp;: Accompagnateur(trice) de voyages&nbsp; - Chef(fe) de produit touristique &ndash; Conseiller(&egrave;re) en s&eacute;jour &ndash; H&ocirc;te(esse) d&rsquo;accueil</li>\r\n</ul>");
        $filiere6->setTitle("Gestion - Administration");
        $filiere6->setTitleBlock1("Qualités requises");
        $filiere6->setTitleBlock2("Compétences développées");
        $filiere6->setTitleBlock3("Les formations en entreprise");
        $filiere6->setTitleBlock4("Vie active");
        $filiere6->setTitleBlock5("Poursuite d’études");
        $manager->persist($filiere6);

        // 7. Métiers de la Mode - vêtements
        $filiere7 = new Filiere();
        $filiere7->setCandidate("Admission après la classe de 3ème -  La candidature s’effectue par la procédure AFFELNET dans l’établissement d’origine");
        $filiere7->setDescription("<p>Le titulaire du Bac pro Mode intervient dans le cadre de fabrications en petites s&eacute;ries et dans le suivi de leurs productions. Il&nbsp;exerce dans l&rsquo;industrie&nbsp;: en atelier, en bureau d&#39;&eacute;tudes, ou en bureau des m&eacute;thodes, en qualit&eacute; d&rsquo;assistant mod&eacute;liste, assistant prototypiste.</p>");
        $filiere7->setTextBlock1("<ul>\r\n\t<li>Motivation</li>\r\n\t<li>Sensibilit&eacute;</li>\r\n\t<li>Passion pour l&rsquo;univers de la mode</li>\r\n\t<li>Sens de la m&eacute;thode et de l&rsquo;analyse</li>\r\n\t<li>Aptitude au travail en &eacute;quipe</li>\r\n\t<li>Int&eacute;r&ecirc;t pour l&rsquo;&eacute;volution des technologies e des mat&eacute;riaux et des mat&eacute;riels</li>\r\n</ul>");
        $filiere7->setTextBlock2("<ul>\r\n\t<li>Participe &agrave; la mise au point d&rsquo;un dossier technique, d&rsquo;un mod&egrave;le, industrialisation d&rsquo;un produit.</li>\r\n\t<li>R&eacute;alise le prototype du mod&egrave;le, &eacute;value la conformit&eacute; esth&eacute;tique et fonctionnelle, contr&ocirc;le la qualit&eacute; du produit fini</li>\r\n\t<li>Etudie les mat&eacute;riaux</li>\r\n\t<li>DAO (Dessin Assist&eacute; par Ordinateur)</li>\r\n\t<li>CAO (Conception Assist&eacute;e par Ordinateur)</li>\r\n</ul>");
        $filiere7->setTextBlock3("<p>22 semaines de stage en entreprise r&eacute;parties sur 3 ans que dure la formation&nbsp;: entreprises de confection pr&ecirc;t &agrave; porter&nbsp;- lingerie &ndash; ameublement &ndash; cr&eacute;ation - essayage -retouches .</p>\r\n\r\n<p>Possibilit&eacute; d&rsquo;effectuer une p&eacute;riode de formation en entreprise (4 semaines) dans un pays d&rsquo;Europe avec Erasmus+</p>");
        $filiere7->setTextBlock4("<p>Prototypiste en mat&eacute;riaux souples &ndash; op&eacute;rateur/trice confection pr&ecirc;t &agrave; porter textile et v&ecirc;tement de peau &ndash; sportwear-ameublement</p>\r\n\r\n<p>Agencement int&eacute;rieur d&rsquo;automobiles &ndash; la voilerie technique (mat&eacute;riel de sport) &ndash;les articles fonctionnels (param&eacute;dical, bagagerie, sacs &agrave; dos, stores, &hellip;)</p>");
        $filiere7->setTextBlock5("<ul>\r\n\t<li>BTS M&eacute;tiers de la Mode &ndash; v&ecirc;tements&nbsp;: habillement ou&nbsp; chaussure (Mod&eacute;lisme Industriel ou Productique)</li>\r\n\t<li>BTS Productique textile (filature &ndash; Bonneterie &ndash; Tissage)</li>\r\n\t<li>BTS Textile et environnement</li>\r\n\t<li>BTS Design de Mode (apr&egrave;s une ann&eacute;e de mise &agrave; niveau en Arts Appliqu&eacute;s)</li>\r\n</ul>");
        $filiere7->setTitle("Métiers de la Mode - vêtements");
        $filiere7->setTitleBlock1("Qualités requises");
        $filiere7->setTitleBlock2("Compétences développées");
        $filiere7->setTitleBlock3("Les formations en entreprise");
        $filiere7->setTitleBlock4("Vie active");
        $filiere7->setTitleBlock5("Poursuite d’étude");
        $manager->persist($filiere7);

        // 8. Vente Option B produits d’équipement courant
        $filiere8 = new Filiere();
        $filiere8->setCandidate("Admission après la classe de 3ème -  La candidature s’effectue par la procédure AFFELNET dans l’établissement d’origine");
        $filiere8->setDescription("<p>Le titulaire de ce dipl&ocirc;me accueille et informe le client, pr&eacute;sente les produits, conseille, r&eacute;alise la vente. Sous la responsabilit&eacute; d&rsquo;un responsable, il r&eacute;ceptionne les produits, les contr&ocirc;le, les &eacute;tiquette, les enregistre pour suivre le stock, fait l&rsquo;inventaire, aide &agrave; la pr&eacute;sentation de la vitrine&hellip;</p>\r\n\r\n<p>Il est employ&eacute; dans les commerces de d&eacute;tail non alimentaires ou chez les grossistes.</p>");
        $filiere8->setTextBlock1("<ul>\r\n\t<li>Sens de la relation</li>\r\n\t<li>Assurance</li>\r\n\t<li>Politesse, discr&eacute;tion, patience, capacit&eacute; d&rsquo;&eacute;coute</li>\r\n\t<li>Dynamisme, autonomie,</li>\r\n\t<li>Rigueur</li>\r\n\t<li>Pr&eacute;sentation soign&eacute;e et adapt&eacute;e &agrave; l&rsquo;image du magasin</li>\r\n\t<li>Disponibilit&eacute; (samedis, veilles de f&ecirc;tes,&hellip;</li>\r\n</ul>");
        $filiere8->setTextBlock2("<p>Identifier les diff&eacute;rentes familles de produits et d&eacute;terminer les produits n&eacute;cessaires au r&eacute;assortiment - Aider &agrave; la r&eacute;ception et v&eacute;rification des produits, les stocker, les acheminer vers la surface de vente</p>\r\n\r\n<p>La vente&nbsp;: accueillir le client - rechercher ses besoins et lui pr&eacute;senter les produits correspondants &ndash; D&eacute;montrer &ndash; Argumenter &ndash; conclure la vente &ndash; emballer les produits</p>\r\n\r\n<p>Accompagner la vente&nbsp;: actualiser le fichier client &ndash; Recevoir les r&eacute;clamations &ndash; participer aux manifestations promotionnelles</p>");
        $filiere8->setTextBlock3("<p>16 semaines de stage en entreprise, r&eacute;parties sur 2 ans que dure la formation, &nbsp;dans les boutiques sp&eacute;cialis&eacute;es comme le pr&ecirc;t &agrave; porter, chaussures, maroquinerie, jouet, bijouterie, &eacute;lectrom&eacute;nager,&hellip;</p>");
        $filiere8->setTextBlock4("<p>Vendeur/euse en magasin</p>");
        $filiere8->setTextBlock5("<p>Bac Pro Commerce&nbsp;: commer&ccedil;ant en alimentation, t&eacute;l&eacute;vendeur(euse), vendeur(euse) en magasin</p>\r\n\r\n<p>Bac pro technicien conseil vente&nbsp;de produits de jardin /en animalerie&nbsp;: vendeur(euse) en animalerie, vendeur(euse) en magasin</p>\r\n\r\n<p>Bac pro vente (prospection, n&eacute;gociation, suivi de client&egrave;le)&nbsp;: attach&eacute;(e) commercial(e), t&eacute;l&eacute;vendeur(euse), vendeur(euse)-magasinier(&egrave;re) en fournitures automobiles</p>\r\n\r\n<p>Bac Pro Accueil&nbsp;: H&ocirc;te. H&ocirc;tesse d&rsquo;accueil, de caisse, en agence &eacute;v&eacute;nementielle, standardiste</p>");
        $filiere8->setTitle("Vente Option B produits d’équipement courant");
        $filiere8->setTitleBlock1("Qualités requises");
        $filiere8->setTitleBlock2("Compétences développées");
        $filiere8->setTitleBlock3("Les formations en entreprise");
        $filiere8->setTitleBlock4("Vie active");
        $filiere8->setTitleBlock5("Poursuite d’étude");
        $manager->persist($filiere8);

        // 9. Formation Aide Soignant(e)
        $filiere9 = new Filiere();
        $filiere8->setCandidate("Réservée aux titulaires des Bacs Pro ASSP ou SAPAT Après réussite au concours d’entrée");
        $filiere9->setDescription("<p>Le titulaire du Dipl&ocirc;me d&rsquo;Etat Aide Soignant assure, au sein de l&rsquo;&eacute;quipe m&eacute;dicale, l&rsquo;hygi&egrave;ne et le confort des patients (toilette, repas, habillage...) et les t&acirc;ches d&rsquo;entretien (changement de literie, rangement et nettoyage de la chambre).<br />\r\nSa mission s&rsquo;effectue en collaboration et sous la responsabilit&eacute; de l&rsquo;infirmier. L&rsquo;aide-soignant(e) travaille principalement dans des &eacute;tablissements hospitaliers. Il travaille aussi dans les maisons de retraite, les centres de soins et, parfois, &agrave; domicile.</p>\r\n\r\n<p>La formation est propos&eacute;e aux titulaires des BACS PRO ASSP ou SAPAT&nbsp;, ou actuellement en terminale (l&rsquo;inscription d&eacute;finitive est subordonn&eacute;e &agrave; l&rsquo;admission au bac).</p>");
        $filiere9->setTextBlock1("<ul>\r\n\t<li>Rigueur</li>\r\n\t<li>Disponibilit&eacute;</li>\r\n\t<li>Qualit&eacute; humaine</li>\r\n\t<li>Patience</li>\r\n\t<li>Capacit&eacute; d&rsquo;initiative et esprit d&rsquo;&eacute;quipe</li>\r\n\t<li>R&eacute;sistance physique</li>\r\n\t<li>Bon &eacute;quilibre personnel</li>\r\n</ul>");
        $filiere9->setTextBlock2("<ul>\r\n\t<li>Appr&eacute;cier l&rsquo;&eacute;tat clinique d&rsquo;une personne,</li>\r\n\t<li>R&eacute;aliser les soins adapt&eacute;s &agrave; l&rsquo;&eacute;tat clinique de la personne</li>\r\n\t<li>Etablir une communication adapt&eacute;e &agrave; la personne et son entourage</li>\r\n\t<li>Utiliser les techniques d&rsquo;entretien des locaux et du mat&eacute;riel sp&eacute;cifiques aux &eacute;tablissements sanitaires, sociaux et m&eacute;dico-sociaux (Bac Pro SAPAT)</li>\r\n</ul>");
        $filiere9->setTextBlock3("<p><em>Pour les ASSP</em>&nbsp;: 315 heures d&rsquo;enseignement (modules 2 &ndash; 3 &ndash; 5) et 12 semaines de stage clinique</p>\r\n\r\n<p><em>Pour les SAPAT</em>&nbsp;: 350 heures d&rsquo;enseignement (modules 2 &ndash; 3 &ndash; 5 &ndash; 6) et 14 semaines de stage clinique</p>");
        $filiere9->setTextBlock4("<p>Aide soignante dans un &eacute;tablissement de soins, une r&eacute;sidence pour personnes &acirc;g&eacute;es,&nbsp; un &eacute;tablissement relevant du milieu du handicap</p>");
        $filiere9->setTextBlock5("<p><strong>Les inscriptions au concours d&rsquo;entr&eacute;e &agrave; la formation</strong> sont ouvertes du <strong>10/01/2019 au 05/03/2019 &agrave; 17h </strong>(date limite de d&eacute;p&ocirc;t du dossier). Le dossier est &agrave; disposition sur le site&nbsp;:</p>\r\n\r\n<p>http://marcelle-parde.elycee.rhonealpes.fr</p>");
        $filiere9->setTitle("Formation Aide Soignant(e)");
        $filiere9->setTitleBlock1("Qualités requises");
        $filiere9->setTitleBlock2("Compétences développées");
        $filiere9->setTitleBlock3("La formation");
        $filiere9->setTitleBlock4("Vie active");
        $filiere9->setTitleBlock5("Inscription");
        $manager->persist($filiere9);

        /**
         * Génération des fixtures des types de question
         */
        $simpleTextQuestionType = new QuestionType();
        $simpleTextQuestionType->setLabel('Simple Text');
        $simpleTextQuestionType->setResume('Un champs de saisie de texte sur une ligne.');
        $manager->persist($simpleTextQuestionType);

        
        $textareaTextQuestionType = new QuestionType();
        $textareaTextQuestionType->setLabel('Textarea');
        $textareaTextQuestionType->setResume('Un champs de saisie de texte sur plusieurs lignes possibles.');
        $manager->persist($textareaTextQuestionType);


        $simpleChoiceQuestionType = new QuestionType();
        $simpleChoiceQuestionType->setLabel('Simple Choice');
        $simpleChoiceQuestionType->setResume('Un choix multiple à une seule réponse possible.');
        $manager->persist($simpleChoiceQuestionType);


        $multipleChoiceQuestionType = new QuestionType();
        $multipleChoiceQuestionType->setlabel('Multiple Choice');
        $multipleChoiceQuestionType->setResume('Un choix multiple à plusieurs réponses possibles.');
        $manager->persist($multipleChoiceQuestionType);


        /**
         * Génération des fixtures des évènements
         */
        $dateOfOpening = new \DateTimeImmutable();
        $dateOfClosure = $dateOfOpening->add(new \DateInterval('P7M3D'));
        $event = new Event("Journée Porte-Ouvertes ", $dateOfOpening, $dateOfClosure);


        /**
         * Génération des fixtures des sondages
         */
        $survey = new Survey("Formulaire de satisfaction");

        /**
         * Génération des fixtures des questions
         */
        /** --- Question n°1 --- */
        $question = new Question("Où avez-vous connu le lycée ?");
        $question->setQuestionType($simpleTextQuestionType);
        /**
         * Génération des fixtures des réponses pour la question précédente
         */
        $reponse = new Response();
        $reponse->setValue("J'ai reçu une publicité dans ma boîte mail.");
        $reponse->setQuestion($question);
        $question->addResponse($reponse);
        $manager->persist($reponse);
        $reponse = new Response();
        $reponse->setValue("J'ai pu lire la brochure de votre lycée que j'ai reçu dans ma boîte aux lettres.");
        $reponse->setQuestion($question);
        $question->addResponse($reponse);
        $manager->persist($reponse);
        $survey->addQuestion($question);

        /** --- Question n°2 --- */
        $question = new Question("Quelle remarque pouvez-vous faire ?");
        $question->setQuestionType($textareaTextQuestionType);
        /**
         * Génération des fixtures des réponses pour la question précédente
         */
        $reponse = new Response();
        $reponse->setQuestion($question);
        $reponse->setValue("Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. ");
        $question->addResponse($reponse);
        $manager->persist($reponse);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $reponse->setValue("Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. ");
        $question->addResponse($reponse);
        $manager->persist($reponse);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $reponse->setValue("Je suis une remarque. Je suis une remarque. Je suis une remarque. ");
        $question->addResponse($reponse);
        $manager->persist($reponse);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $reponse->setValue("Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. Je suis une remarque. ");
        $question->addResponse($reponse);
        $manager->persist($reponse);
        $survey->addQuestion($question);

        /** --- Question n°3 --- */
        /**
         * Dans les cas de questions à choix,
         * On génère les fixtures pour les options à ces questions 
         */
        $question = new Question("Est-ce que le salon vous a plu ?");
        $question->setQuestionType($simpleChoiceQuestionType);
        $questionOption = new QuestionOption("Oui");
        $question->addQuestionOption($questionOption);
        /**
         * Génération des fixtures des réponses pour la question précédente
         */
        $reponse = new Response();
        $reponse->setQuestion($question);
        $questionOption->addResponse($reponse);
        $manager->persist($reponse);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $questionOption->addResponse($reponse);
        $manager->persist($reponse);
        $questionOption = new QuestionOption("Non");
        $question->addQuestionOption($questionOption);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $questionOption->addResponse($reponse);
        $manager->persist($reponse);
        $survey->addQuestion($question);

        /** --- Question n°4 --- */
        $question = new Question("Quelle filière préferez vous ?");
        $question->setQuestionType($multipleChoiceQuestionType);
        $questionOption = new QuestionOption("ASSP");
        $question->addQuestionOption($questionOption);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $questionOption->addResponse($reponse);
        $manager->persist($reponse);
        $questionOption = new QuestionOption("Gestion Administration");
        $question->addQuestionOption($questionOption);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $questionOption->addResponse($reponse);
        $manager->persist($reponse);
        $questionOption = new QuestionOption("Métiers de la Mode");
        $question->addQuestionOption($questionOption);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $questionOption->addResponse($reponse);
        $manager->persist($reponse);
        $reponse = new Response();
        $reponse->setQuestion($question);
        $questionOption->addResponse($reponse);
        $manager->persist($reponse);
        $survey->addQuestion($question);

        $event->addSurvey($survey);

        $manager->persist($event);

        $manager->flush();
    }
}
