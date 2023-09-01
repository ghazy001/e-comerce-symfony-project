<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'disabled'=> true,
                'label'=> 'Adresse email'
            ])
            ->add('firstname', null, [
                'required'   => false,
                'disabled'=> true,
                'label'=> 'Prenom'

            ])
            ->add('lastname', null, [
                'required'   => false,
                'disabled'=> true,
                'label'=> 'Nom'

            ])

            ->add('old_password',PasswordType::class,[
                'label'=>'Mot de passe',
                'mapped'=>  false,
                'attr'=> [
                    'placeholder'=>'Veuillez saisir votre mot de passe actuel'
                ]
            ])

            ->add('new_password',RepeatedType::class,[
                'type'=> PasswordType::class,
                'mapped'=>  false,
                'invalid_message' => 'le mot de passe et la confirmation doit etre identique',
                'label'=>'Nouveau mot de passe ',
                'required'=>true,
                'first_options'=> [
                    'label'=>' Nouveau mot de passse',
                    'attr'=>['placeholder'=>'Merci de saisir votre mot de passe']
                ],
                'second_options'=> [
                    'label'=>'confirmez votre nouveau mot de passe',
                    'attr'=>['placeholder'=>'Merci de confirmer votre nouveau mot de passe']
                ]
            ])

            ->add('submit',SubmitType::class,['label'=>"Mettre a jour "
            ])






        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
