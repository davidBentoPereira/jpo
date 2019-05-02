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
        $messages['errors'] = [];
        $messages['success'] = [];

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if(empty($email)) $messages['errors'][] = 'L\'adresse mail renseignée est vide.';
            if(empty($password)) $messages['errors'][] = 'Le mot de passe renseigné est vide.';

            $adminWithTheSameMailAdress = $adminRepo->findOneBy([
                'email' => $email
            ]);
            
            if($adminWithTheSameMailAdress !== null) $messages['errors'][] = 'L\'adresse mail renseignée est déjà utilisée par un administrateur.';

            if(count($messages['errors']) == 0) {
                $newAdmin = new Admin();

                $newAdmin->setEmail($email);
                $newAdmin->setPassword($passwordEncoder->encodePassword(
                    $newAdmin, $password
                ));
                $newAdmin->setRoles(["ROLE_ADMIN"]);
                $manager->persist($newAdmin);
                $manager->flush();
                $messages['success'][] = 'Vous avez ajouté un nouvel administrateur.';
            }
        }

        $admins = $adminRepo->findAll();
        return $this->render('admin/admins/list.html.twig', [
            'admins' => $admins,
            'authChecker' => $authChecker,
            'connectedUser' => $this->getUser(),
            'messages' => $messages
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
        $messages['errors'] = [];
        $messages['success'] = [];
        
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if(empty($email)) $messages['errors'][] = 'L\'adresse mail renseignée est vide.';
            if(empty($password)) $messages['errors'][] = 'Le mot de passe renseigné est vide.';

            $adminsWithTheSameMailAdress = $adminRepo->findOneBy([
                'email' => $email
            ]);
            
            if(count($adminsWithTheSameMailAdress) > 1) $messages['errors'][] = 'L\'adresse mail renseignée est déjà utilisée par un administrateur.';

            if(count($messages['errors']) == 0 ) {
                $connectedUser->setEmail($email);
                $connectedUser->setPassword($passwordEncoder->encodePassword(
                    $connectedUser, $password
                ));
                $manager->persist($connectedUser);
                $manager->flush();
                $messages['success'][] = 'Vous avez modifié votre compte administrateur.';
            }
        }
        return $this->render('admin/admins/edition.html.twig', [
            'connectedUser' => $connectedUser,
            'messages' => $messages
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