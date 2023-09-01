<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    private $entityManger;
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManger = $entityManger;
    }


    #[Route('/compte/modifier-mdp', name: 'account_password')]
    public function index(Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {


        $notification = null;
        $user = $this->getUser();

        $form= $this->createForm(ChangePasswordType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $old_pwd= $form->get('old_password')->getData();

            if($passwordHasher->isPasswordValid($user,$old_pwd)){
                $new_pwd=$form->get('new_password')->getData();
               $password = $passwordHasher->hashPassword($user,$new_pwd);

               $user->setPassword($password);

                $this->entityManger->flush();
                $notification = "votre mot de passe a bien ete mis a jour";



            }
            else {
                $notification = "votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('account/password.html.twig',[
          'form'=>$form->createView(),'notification'=>$notification
        ]);
    }
}
