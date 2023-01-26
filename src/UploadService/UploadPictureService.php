<?php

namespace App\UploadService;

use App\Entity\Picture;
use App\Entity\Trick;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class UploadPictureService
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly RequestStack $requestStack,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function handleUploadPicture(Trick $trick): void
    {
        if ($this->requestStack->getCurrentRequest()->files->get('trick_form')) {
            /** @var Picture[] $pictures */
            $pictures = $trick->getPictures();
            $uploadedFiles = $this->requestStack->getCurrentRequest()->files->get('trick_form')['pictures'];
            $i = 0;
            foreach ($uploadedFiles as $uploadedFile) {
                if ($uploadedFile['addPictures'] === null) {
                    $i++;
                    continue;
                }
                $fileName = md5(uniqid()) . '.' . $uploadedFile['addPictures']->guessExtension();
                $pictures[$i]->setFileName($fileName);
                $uploadedFile['addPictures']->move(
                    strval($this->parameterBag->get('picture_trick_upload_directory')),
                    $fileName
                );
                $i++;
            }
        }
    }

    public function noEmptyFieldPicture(Trick $trick, FormInterface $form): bool
    {
        $error = false;
        if ($this->requestStack->getCurrentRequest()->files->get('trick_form')) {
            /** @var Picture[] $pictures */
            $pictures = $trick->getPictures();
            $uploadedFiles = $this->requestStack->getCurrentRequest()->files->get('trick_form')['pictures'];
            $i = 0;
            foreach ($uploadedFiles as $key => $uploadedFile) {
                if ($uploadedFile['addPictures'] === null) {
                    if ($pictures[$i]->getId() === null) {
                        $error = true;
                        $form->get('pictures')[$key]['addPictures']->addError(
                            new FormError($this->translator->trans(
                                'validators.image.collection_field_is_empty',
                                [],
                                'validators'
                            ))
                        );
                    }
                }
                $i++;
            }
        }
        if ($error) {
            return false;
        }
        return true;
    }
}
