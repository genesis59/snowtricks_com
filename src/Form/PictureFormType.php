<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class PictureFormType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addPictures', FileType::class, [
                'mapped' => false,
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'allowPortrait' => false,
                        'allowPortraitMessage' => $this->translator->trans(
                            'validators.image.allow_portrait_message',
                            [],
                            'validators'
                        ),
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
