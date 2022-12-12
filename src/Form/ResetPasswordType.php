<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ResetPasswordType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'first_options'  => [
                    'mapped' => false,
                    'label_attr' => ['class' => 'mt-3'],
                    'label' => $this->translator->trans('snow_trick.reset.password'),'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'mapped' => false,
                    'label_attr' => ['class' => 'mt-3'],
                    'label' => $this->translator->trans('snow_trick.reset.repeat_password'),
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'type' => PasswordType::class
            ])
            ->add('valider', SubmitType::class, [
                'label' => $this->translator->trans('snow_trick.reset.button_submit'),
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
