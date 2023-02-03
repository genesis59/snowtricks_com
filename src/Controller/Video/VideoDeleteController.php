<?php

namespace App\Controller\Video;

use App\Entity\Trick;
use App\Entity\Video;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class VideoDeleteController extends AbstractController
{
    #[Route('/video/delete/{slug}/{uuid}', name: 'app_video_delete')]
    public function __invoke(
        string $slug,
        string $uuid,
        TrickRepository $trickRepository,
        VideoRepository $videoRepository,
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
        /** @var Video $video */
        $video = $videoRepository->findOneBy(['uuid' => $uuid]);
        if ($video == null) {
            throw $this->createNotFoundException($translator->trans('exceptions.not_found', [], 'exceptions'));
        }

        $trick->removeVideo($video);
        $trickRepository->save($trick, true);
        return $this->redirectToRoute('app_trick_update', [
            'slug' => $slug
        ]);
    }
}
