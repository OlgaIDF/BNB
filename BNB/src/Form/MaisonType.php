<?php

namespace App\Form;

use App\Entity\Maisons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
                'label' => 'Titre de l\'annonce',
                'attr' => [
                    'placeholder' => 'ex.: Jolie maison de campagne'
                ]
            ]
            )
            ->add('description', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex.: Maison de campage en bord de rivière'
                ]
            ])
            ->add('chambres', IntegerType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex.: 9',
                    'min' => 0
                ]
                
            ])
            ->add('prix', MoneyType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex.: 99,00',
                    'min' => 0
                ]
            ])
            ->add('note', ChoiceType::class, [
                'choices' => [
                    'Mauvais' => 1,
                    'Passable' => 2,
                    'Moyen' => 3,
                    'Bien' => 4,
                    'Très bien' => 5
                ]
            ])
            ->add('superficie', IntegerType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex.: 129',
                    'min' => 0
                ]
            ])
            ->add('img1', FileType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Photo 1',
                'attr' => [
                    'placeholder' => 'ex.: maison1-1.png'
                ]
            ])
            ->add('img2', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Photo 2',
                'attr' => [
                    'placeholder' => 'ex.: maison1-2.png'
                ]
            ])
            ->add('img3', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Photo 3',
                'attr' => [
                    'placeholder' => 'ex.: maison1-3.png'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Maisons::class,
        ]);
    }
}