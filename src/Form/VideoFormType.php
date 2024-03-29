<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Contracts\Translation\TranslatorInterface;

class VideoFormType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('source', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('snow_trick.video.form.source_placeholder')
                ],
                'constraints' => [
                    new NotBlank(message: $this->translator->trans('validators.not_blank', [], 'validators')),
                    new Url(message: 'validators.url.bad_format'),
                    new Regex(
                        pattern: '/^(https:\/\/www\.youtube\.com\/embed\/[\w-]{2,11}|https:\/\/www\.dailymotion\.com\/embed\/video\/[\w-]{2,11})$/',
                        message: 'validators.regex.video'
                    )
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
