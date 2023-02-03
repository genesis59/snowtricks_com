<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickFormType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pictures', CollectionType::class, [
                'entry_type' => PictureFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ])
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('snow_trick.trick.form.label_name'),
                'attr' => [
                    'placeholder' => $this->translator->trans('snow_trick.trick.form.name_placeholder')
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->translator->trans('snow_trick.trick.form.label_description'),
                'attr' => [
                    'rows' => 10,
                    'placeholder' => $this->translator->trans('snow_trick.trick.form.description_placeholder')
                ]
            ])
            ->add('trickGroup', EntityType::class, [
                'label' => false,
                'class' => Group::class,
                'choice_label' => 'name',
                'placeholder' => $this->translator->trans('snow_trick.trick.form.trick_group_select_default'),
                'constraints' => [
                    new NotBlank(message: 'validators.not_blank_select')
                ]
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
