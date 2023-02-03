<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ManageMainPictureController extends AbstractController
{
    #[Route('/manage/main/picture/{slug}/{uuid}', name: 'app_manage_main_picture')]
    public function __invoke(
        string $slug,
        string $uuid,
        TrickRepository $trickRepository,
        PictureRepository $pictureRepository,
        ManagerRegistry $managerRegistry,
        TranslatorInterface $translator
    ): Response {
        /** @var Trick $trick */
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        if ($trick == null) {
            throw $this->createNotFoundException($translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        /** @var Picture $picture */
        $picture = $pictureRepository->findOneBy(['uuid' => $uuid]);
        if ($picture == null || $picture->getTrick() !== $trick) {
            throw $this->createNotFoundException($translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        if ($picture->isIsMain()) {
            $picture->setIsMain(false);
            $pictureRepository->save($picture, true);
            return $this->redirectToRoute('app_trick_update', [
                'slug' => $trick->getSlug(),
            ]);
        }
        /** @var Picture $mainPicture */
        $mainPicture = $pictureRepository->findOneBy(['isMain' => true,'trick' => $trick->getId()]);

        if ($mainPicture !== null) {
            $mainPicture->setIsMain(false);
        }

        $picture->setIsMain(true);
        $managerRegistry->getManager()->flush();

        return $this->redirectToRoute('app_trick_update', [
            'slug' => $trick->getSlug(),
        ]);
    }
}
