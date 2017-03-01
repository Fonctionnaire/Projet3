<?php

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('dateVisite', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de votre visite',
                'attr' => ['class' => 'datepicker'],
                'placeholder' => 'Cliquez pour choisir une date',
                'format' => 'dd-MM-yyyy',
            ))
            ->add('typeTicket', ChoiceType::class, array(
                'choices' => array(
                    'Journée complète' => true,
                    'Demi-journée : à partir de 14 heure' => false,
                ),
                'attr' => ['class' => 'typeTicket'],
                'label' => 'Choisissez le type de billet que vous souhaitez',
            ))
            ->add('tickets', CollectionType::class, array(
                'entry_type' => TicketType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Votre adresse Email',
                'attr' => ['placeholder' => 'jeandupond@gmail.com']
            ))
            ->add('valider', SubmitType::class);





    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_commande';
    }


}
