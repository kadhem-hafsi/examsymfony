<?php

namespace App\Form;
use App\Entity\Artiste;
use App\Entity\Oeuvre;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;




class OeuvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('enabled')
            //->add('artiste')

                ->add('artiste',EntityType::class,[
                'class'=>Artiste::class,
                'choice_label'=> 'name',
                'multiple' => false,
                'expanded' => false, 
                ])

            ->add('save',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
        ]);
    }



     
 
          
        
}
