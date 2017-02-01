<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TicketType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('dateVisite', DateType::class, array(

                'html5' => false,
                'label' => 'Date de votre visite',
                'attr' => ['class' => 'datepicker'],
                'placeholder' => 'Cliquez pour choisir une date',
                'format' => 'dd-MM-yy',
            ))
            ->add('typeTicket', ChoiceType::class, array(
                'choices' => array(
                    'Journée complète' => true,
                    'Demi-journée : à partir de 14 heure' => false,
                ),
                'label' => 'Choisissez le type de billet que vous souhaitez'
            ))
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class, array('label' => 'Prénom'))
            ->add('dateNaissance', BirthdayType::class, array(
                'label' => 'Votre date de naissance',
                'format' => 'dd-MM-yyyy',
                ))
            ->add('pays', CountryType::class, array('data' => 'FR'))
            ->add('reduction', CheckboxType::class, array('required' => false))
            ->add('commande', CommandeType::class)
            ->add('Valider', SubmitType::class)


        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
