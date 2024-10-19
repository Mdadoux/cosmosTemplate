<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ProjectType extends AbstractType
{

   public function __construct(private FormListenerFactory $formListenerFactory)
   {
   }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug', TextType::class, [
                'required' => false,
            ])
            ->add('description')
            ->add('active')
            ->add('idClient', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->formListenerFactory->autoSlug('title'))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->formListenerFactory->timeStemps());
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
