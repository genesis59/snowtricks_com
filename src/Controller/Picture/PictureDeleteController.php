<?php

namespace App\Controller\Picture;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class PictureDeleteController extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly PictureRepository $pictureRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/picture/delete/{slug}/{uuid}', name: 'app_picture_delete')]
    public function __invoke(string $slug, string $uuid): Response
    {
        /** @var Trick $trick */
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        if ($trick == null) {
            throw $this->createNotFoundException($this->translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        /** @var Picture $picture */
        $picture = $this->pictureRepository->findOneBy(['uuid' => $uuid]);
        if ($picture == null) {
            throw $this->createNotFoundException($this->translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        if (is_string($this->getParameter('picture_trick_upload_directory')) && is_string($picture->getFileName())) {
            $fileName = $this->getParameter('picture_trick_upload_directory') . $picture->getFileName();
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }

        $trick->removePicture($picture);
        $this->trickRepository->save($trick, true);
        return $this->redirectToRoute('app_trick_update', [
            'slug' => $slug
        ]);
    }
}
