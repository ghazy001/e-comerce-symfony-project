<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('firstname', TextType::class, [
                'label' => 'Votre prenom',
                'constraints'=>new Length([
                    'min'=> 2,
                    'max'=>30
                ]),
                'attr' => ['placeholder' => 'Merci de saisir votre prénom'],
            ])

            ->add('lastname', TextType::class,['label'=> 'Votre nom',
                'constraints'=>new Length([
                    'min'=> 2,
                    'max'=>30
                ]),
                'attr'=> ['placeholder'=> 'Merci de sasir votre nom ' ]

            ])

            ->add('email',TextType::class,[
                'label' => 'Votre adresse mail',
                'constraints'=>new Length([
                    'min'=> 2,
                    'max'=>50
                ]),
                'attr' => ['placeholder' => 'Merci de saisir votre adresse mail']
            ])


            ->add('password',RepeatedType::class,[
                'type'=> PasswordType::class,
                'invalid_message' => 'le mot de passe et la confirmation doit etre identique',
                'label'=>'votre mot de passe ',
                'required'=>true,
                'first_options'=> [
                    'label'=>'Mot de passse',
                    'attr'=>['placeholder'=>'Merci de saisir votre mot de passe']
                ],
                'second_options'=> [
                    'label'=>'confirmez votre mot de passe',
                    'attr'=>['placeholder'=>'Merci de confirmer votre mot de passe']
                ]
            ])

            ->add('submit',SubmitType::class,['label'=>"S'inscrire"
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
