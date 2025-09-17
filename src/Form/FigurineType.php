<?php
namespace App\Form;

use App\Entity\Figurine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{TextType,TextareaType,UrlType,MoneyType,SubmitType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FigurineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('title', TextType::class, ['constraints'=>[new Assert\Length(['min'=>3])]])
            ->add('description', TextareaType::class, ['required'=>false])
            ->add('imageName', UrlType::class, ['label'=>'Image (URL) or upload via Vich'])
            ->add('price', MoneyType::class, ['currency'=>'EUR'])
            ->add('save', SubmitType::class, ['label'=>'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>Figurine::class]);
    }
}
