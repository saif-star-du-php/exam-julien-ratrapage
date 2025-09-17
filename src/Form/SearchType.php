<?php

namespace App\Form;

use App\Model\SearchData;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;


class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => 'searchType.search',
                'attr' => [
                    'placeholder' => 'Recherche via un mot clé...'
                ]
            ])    
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' =>SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
