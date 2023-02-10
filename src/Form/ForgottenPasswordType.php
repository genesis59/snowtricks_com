<?php

namespace App\Form;

use App\Validator\AccountIsActivated;
use App\Validator\AccountIsActivatedValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ForgottenPasswordType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new AccountIsActivated($this->translator),
                    new Length(max:255, maxMessage: 'validators.length.max'),
                    new Email(message: 'validators.email'),
                    new NotBlank(message: 'validators.not_blank')
                ],
                'label_attr' => ['class' => 'mt-3'],
                'label' => $this->translator->trans('snow_trick.forgotten.email'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('valider', SubmitType::class, [
                'label' => $this->translator->trans('snow_trick.forgotten.button_submit'),
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
