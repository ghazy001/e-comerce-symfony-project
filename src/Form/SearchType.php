<?php

namespace App\Form;

use App\classe\Search;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => false,
                'required'=>false,
                'attr'=> [
                    'placeholder'=> 'Votre recherche ...',
                    'class'=> 'form-control-sm'

                ]

            ])
        ->add('categories',EntityType::class,[
            'label' => false,
            'required'=>false,
            'class'=> Category::class,
            'multiple'=> true,
            'expanded'=>true
        ])

        ->add('sumbit',SubmitType::class,[
            'label' => 'Filtrer',
            'attr'=> [
                'class'=> 'btn-block btn-info'
            ]
        ])
        ;



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method'=>'GET',
            'crsf_protection'=>false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }





}




?>