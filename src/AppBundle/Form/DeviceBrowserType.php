<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DeviceBrowserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('device', EntityType::class,[
                'class' => 'AppBundle:Device'
                ,'choice_label' => 'name'
            ])
            ->add('browserversion', EntityType::class,[
                'class' => 'AppBundle:Browserversion'
                ,'choice_label' => function ($browserVersion) {
                    return  $browserVersion->getBrowser()->getName().' '.$browserVersion->getVersion();
                }
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DeviceBrowser'
            ,'csrf_protection' => false
        ));
    }
}
