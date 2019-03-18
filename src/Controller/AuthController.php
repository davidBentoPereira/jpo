<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Admin;
use App\Service\EncryptingService;

class AuthController extends AbstractController
{
    private $messages = [];

    public function login(Request $request, ObjectManager $manager)
    {
        if($request->isMethod('POST')){
            $mail = $request->request->get('mail');
            $password = $request->request->get('password');
            $encryptingService = new EncryptingService($password);

            $admin = $this->getDoctrine()
                ->getRepository(Admin::class)
                ->findOneBy([
                    "mail" => $mail,
                    "encryptedPassword" => $encryptingService->getEncryptedString()
                ]);

            if ($admin)
            {
                return $this->redirectToRoute('dashboard');
            }
            else{
                $this->messages[] = [
                    'content' => 'Adresse mail ou mot de passe invalide.',
                    'class' => 'danger'
                ];
            }
        }

        return $this->render('front/login.html.twig', ['messages' => $this->messages]);
    }

    public function logout()
    {
        $this->messages[] = [
            'content' => 'Vous vous êtes déconnecté.',
            'class' => 'success'
        ];
        return $this->render('front/login.html.twig', ['messages' => $this->messages]);
    }
}
