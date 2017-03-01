<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
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
            ->add('nom', TextType::class, array('attr' => array(
                'placeholder' => "Nom",
                'class' => 'nom'
            ),
                'label' => false
            ))
            ->add('prenom', TextType::class, array('attr' => array(
                'placeholder' => "Prénom",
                'class' => 'prenom'
            ),
            'label' => false
            ))
            ->add('dateNaissance', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'dateNaissance'],
            ))
            ->add('pays', CountryType::class, array('data' => 'FR',
                'label' => false,
                'attr' => ['class' => 'select']))
            ->add('reduction', CheckboxType::class, array('required' => false,
                'label' => 'Tarif réduit (1)',
                'attr' => array('class' => 'checkBox ')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class
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
