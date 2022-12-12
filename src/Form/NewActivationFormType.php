<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class NewActivationFormType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label_attr' => ['class' => 'mt-3'],
                'label' => $this->translator->trans('snow_trick.new_activation.email'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('valider', SubmitType::class, [
                'label' => $this->translator->trans('snow_trick.new_activation.button_submit'),
                'attr' => [
                    'class' => 'btn btn-lg btn-primary mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
