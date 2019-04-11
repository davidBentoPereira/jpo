<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LoginType;

class AuthController extends AbstractController
{
    private $messages = [];

    public function login(
        Request $request,
        ObjectManager $manager,
        UserPasswordEncoderInterface $encoder,
        AuthenticationUtils $authenticationUtils,
        AuthorizationCheckerInterface $authChecker
    )
    {
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('filiere_list');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class);

        return $this->render('front/login.html.twig',
            [
                'messages' => $this->messages,
                'loginForm' => $form->createView()
            ]
        );
    }
}
