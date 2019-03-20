<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Admin;

class AuthController extends AbstractController
{
    private $messages = [];

    public function login(
        Request $request,
        ObjectManager $manager,
        UserPasswordEncoderInterface $encoder
    )
    {
        if($request->isMethod('POST'))
        {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findOneBy([
                "email" => $email
                ]);

            if (
                $admin &&
                $encoder->isPasswordValid($admin, $password)
            )
            {
                // return $this->redirectToRoute('dashboard');
            }
            else
            {
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
