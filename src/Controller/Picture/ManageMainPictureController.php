<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ManageMainPictureController extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly PictureRepository $pictureRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/manage/main/picture/{slug}/{uuid}', name: 'app_manage_main_picture')]
    public function __invoke(string $slug, string $uuid): Response
    {
        /** @var Trick $trick */
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        if ($trick == null) {
            throw $this->createNotFoundException($this->translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        /** @var Picture $picture */
        $picture = $this->pictureRepository->findOneBy(['uuid' => $uuid]);
        if ($picture == null || $picture->getTrick() !== $trick) {
            throw $this->createNotFoundException($this->translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        if ($picture->isIsMain()) {
            $picture->setIsMain(false);
            $this->pictureRepository->save($picture, true);
            return $this->redirectToRoute('app_trick_update', [
                'slug' => $trick->getSlug(),
            ]);
        }
        /** @var Picture $mainPicture */
        $mainPicture = $this->pictureRepository->findOneBy(['isMain' => true]);
        if ($mainPicture != null) {
            $mainPicture->setIsMain(false);
            $this->pictureRepository->save($mainPicture);
        }
        $picture->setIsMain(true);
        $this->pictureRepository->save($picture, true);

        return $this->redirectToRoute('app_trick_update', [
            'slug' => $trick->getSlug(),
        ]);
    }
}
