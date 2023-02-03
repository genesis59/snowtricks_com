<?php

namespace App\UploadService;

use App\Entity\Photo;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class UploadService
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

    public function handleUploadPhoto(User $user): void
    {
        if (
            $this->requestStack->getCurrentRequest()->files->get('user_form') &&
            $this->requestStack->getCurrentRequest()->files->get('user_form')['photo']
        ) {
            $uploadedFile = $this->requestStack->getCurrentRequest()->files->get('user_form');
            $fileName = md5(uniqid()) . '.' . $uploadedFile['photo']->guessExtension();
            $photo = new Photo();
            $photo->setUser($user);
            $photo->setUuid(Uuid::v4());
            $photo->setName($fileName);
            $user->setPhoto($photo);
            $uploadedFile['photo']->move(
                strval($this->parameterBag->get('photo_user_upload_directory')),
                $fileName
            );
        }
    }
}
