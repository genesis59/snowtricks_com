<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickFormType extends AbstractType
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
                'multiple' => true,
                'required' => false,
//                'constraints' => [
//                    new Image([
//                        'mimeTypes' => [
//                            'image/jpeg',
//                            'image/jpg',
//                            'image/png',
//                            'image/webp',
//                        ],
//                        'mimeTypesMessage' => 'format accepté fffff'
//                    ])
//                ]
            ])
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('snow_trick.trick.form.name_placeholder')
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'rows' => 10,
                    'placeholder' => $this->translator->trans('snow_trick.trick.form.description_placeholder')
                ]
            ])
            ->add('trickGroup', EntityType::class, [
                'label' => false,
                'class' => Group::class,
                'choice_label' => 'name',
                'placeholder' => $this->translator->trans('snow_trick.trick.form.trick_group_select_default')
            ])
            ->add('valider', SubmitType::class, [
                'label' => $this->translator->trans('snow_trick.trick.form.submit_label')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
