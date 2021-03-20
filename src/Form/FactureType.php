<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Facture;
use App\Entity\Prestataire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('prestataire',EntityType::class,[
            "class"=>Prestataire::class,
            "choice_label"=>"nom"
        ])
            ->add('mois', DateType::class, [
                'label'=>"Mois à facturé",
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('prestation')
            ->add('quantite')
            ->add('quantiteType',ChoiceType::class,[
                'choices'=>[
                    "Heures"=>0,
                    "Jours"=>1,
                    "Prestation"=>2
                ]
            ])
            ->add('taux')
            ->add('date', DateType::class, [
                'label'=>"date d'envoi",
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker',],
            ])
            ->add('mention')
            ->add('client',EntityType::class,[
                "class"=>Client::class,
                "choice_label"=>"entreprise"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
