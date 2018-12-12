<?php

namespace OC\PlatformBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use OC\PlatformBundle\Form\CategoryType;
use OC\PlatformBundle\Form\ImageType;

class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateTimeType::class)
            ->add('title')
            ->add('author')
            ->add('content')
            ->add('published',CheckboxType::class, array('required' => false))
            ->add('nbApplications')
            ->add('slug')
            ->add('image',ImageType::class) // Ajoutez cette ligne
            ->add('categories', EntityType::class, array(
                    'class'        => 'OCPlatformBundle:Category',
                    'choice_label' => 'name',
                    'multiple'     => true,
                ))
            ->add('save',SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }
}
