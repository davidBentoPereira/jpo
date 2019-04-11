<?php

namespace App\Controller\admin;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdminRepository;
use App\Entity\Admin;

class AdminController extends AbstractController
{
    public function index(
        UserPasswordEncoderInterface $passwordEncoder,
        AuthorizationCheckerInterface $authChecker,
        AdminRepository $adminRepo,
        ObjectManager $manager,
        Request $request
    ): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if(empty($email)) return $this->redirectToRoute('listAdmins');
            if(empty($password)) return $this->redirectToRoute('listAdmins');

            $adminWithTheSameMailAdress = $adminRepo->findOneBy([
                'email' => $email
            ]);
            
            if($adminWithTheSameMailAdress !== null) return $this->redirectToRoute('listAdmins');
            
            $newAdmin = new Admin();
            
            $newAdmin->setEmail($email);
            $newAdmin->setPassword($passwordEncoder->encodePassword(
                $newAdmin, $password
            ));
            $newAdmin->setRoles(["ROLE_ADMIN"]);
            $manager->persist($newAdmin);            
            $manager->flush();
        }

        $admins = $adminRepo->findAll();
        return $this->render('admin/admins/list.html.twig', [
            'admins' => $admins,
            'authChecker' => $authChecker,
            'connectedUser' => $this->getUser()
        ]);
    }

    public function edition(
        UserPasswordEncoderInterface $passwordEncoder,
        AuthorizationCheckerInterface $authChecker,
        AdminRepository $adminRepo,
        ObjectManager $manager,
        Request $request
    ): Response {
        $connectedUser = $this->getUser();
        
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if(empty($email)) exit;
            if(empty($password)) exit;

            $adminWithTheSameMailAdress = $adminRepo->findOneBy([
                'email' => $email
            ]);
            
            if($adminWithTheSameMailAdress !== null) exit;
            
            $adminUpdated = new Admin();
            
            $adminUpdated->setEmail($email);
            $adminUpdated->setPassword($passwordEncoder->encodePassword(
                $adminUpdated, $password
            ));
            $manager->persist($adminUpdated);            
            $manager->flush();
        }
        return $this->render('admin/admins/edition.html.twig', [
            'connectedUser' => $connectedUser
        ]);
    }

    public function remove(
        AdminRepository $adminRepo,
        ObjectManager $manager,
        string $id
    ): Response {
        $allAdmins = $adminRepo->findAll();
        if(count($allAdmins) === 1) return $this->redirectToRoute('listAdmins');
        $admin = $adminRepo->find($id);
        if($admin){
            if($admin->getId() === $this->getUser()->getId()) return $this->redirectToRoute('listAdmins');
            $manager->remove($admin);
            $manager->flush();
        }
        return $this->redirectToRoute('listAdmins');
    }
}