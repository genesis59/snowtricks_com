<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserFormType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label_attr' => ['class' => 'mt-3'],
                'label' => $this->translator->trans('snow_trick.register.name'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'label_attr' => ['class' => 'mt-3'],
                'label' => $this->translator->trans('snow_trick.register.email'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('photo', FileType::class, [
                'mapped' => false,
                'label' => $this->translator->trans('snow_trick.register.photo'),
                'required' => true,
                'constraints' => [
                    new Image([
                        'maxWidth' => 1280,
                        'maxWidthMessage' => $this->translator->trans(
                            'validators.image.max_width_message',
                            [],
                            'validators'
                        ),
                        'maxHeightMessage' => $this->translator->trans(
                            'validators.image.max_height_message',
                            [],
                            'validators'
                        ),
                        'maxHeight' => 1024,
                        'maxSize' => 1048576,
                        'maxSizeMessage' => $this->translator->trans(
                            'validators.image.max_size_message',
                            [],
                            'validators'
                        ),
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => $this->translator->trans(
                            'validators.image.mime_type_message',
                            [],
                            'validators'
                        )
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, [
                'first_options'  => [
                    'mapped' => false,
                    'label_attr' => ['class' => 'mt-3'],
                    'label' => $this->translator->trans('snow_trick.register.password'),'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'mapped' => false,
                    'label_attr' => ['class' => 'mt-3'],
                    'label' => $this->translator->trans('snow_trick.register.repeat_password'),
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'type' => PasswordType::class
            ])
            ->add('valider', SubmitType::class, [
                'label' => $this->translator->trans('snow_trick.register.button_submit'),
                'attr' => [
                    'class' => 'btn btn-lg btn-primary mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
