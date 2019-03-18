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
    public function login(Request $request, ObjectManager $manager)
    {
        if(!$request->isMethod('POST')) return $this->redirectToRoute('index');

        $mail = $request->request->get('mail');
        $password = $request->request->get('password');
        $encryptingService = new EncryptingService($password);

        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findOneBy([
                "mail" => $mail,
                "encryptedPassword" => $encryptingService->getEncryptedString()
            ]);

        if($admin === null)
        {
            return $this->redirectToRoute('index');
        }
        
        return $this->redirectToRoute('index');        
    }
}
