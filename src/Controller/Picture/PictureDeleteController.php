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
    #[Route('/picture/delete/{slug}/{uuid}', name: 'app_picture_delete')]
    public function __invoke(
        string $slug,
        string $uuid,
        TrickRepository $trickRepository,
        PictureRepository $pictureRepository,
        TranslatorInterface $translator
    ): Response {
        if (!$this->getUser()) {
            $this->addFlash('info', $translator->trans('flashes.info.no-login', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        /** @var Trick $trick */
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        if ($trick == null) {
            throw $this->createNotFoundException($translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        /** @var Picture $picture */
        $picture = $pictureRepository->findOneBy(['uuid' => $uuid]);
        if ($picture == null) {
            throw $this->createNotFoundException($translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        if (is_string($this->getParameter('picture_trick_upload_directory')) && is_string($picture->getFileName())) {
            $fileName = $this->getParameter('picture_trick_upload_directory') . $picture->getFileName();
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }

        $trick->removePicture($picture);
        $trickRepository->save($trick, true);
        return $this->redirectToRoute('app_trick_update', [
            'slug' => $slug
        ]);
    }
}
