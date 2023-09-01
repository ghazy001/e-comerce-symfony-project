<?php

namespace App\Controller;
#namespace Symfony\Component\Security\Core\Encoder;
#namespace Symfony\Component\PasswordHasher


use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;





class RegisterController extends AbstractController

{
    private $entityManger;
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManger = $entityManger;
    }





    #[Route('/inscription', name: 'register' )]

    public function index(Request $request,UserPasswordHasherInterface $passwordHasher) :Response   #, PersistenceManagerRegistry $doctrine)
    {


         $user= new User();



         $form= $this->createForm(RegisterType::class,$user);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()){


             $plaintextPassword = $user->getPassword();

             $user=$form->getData();

             $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);

            $user->setPassword($hashedPassword);

            $this->entityManger->persist($user);
            $this->entityManger->flush();


             #$em = $doctrine->getManager();
             #$em->flush();
            # $this->addFlash('notice', 'Submitted Successfully!!');
             #dd($user);

         }

        return $this->render('register/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
