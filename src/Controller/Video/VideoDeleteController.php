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
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly VideoRepository $videoRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/video/delete/{slug}/{uuid}', name: 'app_video_delete')]
    public function __invoke(string $slug, string $uuid): Response
    {
        /** @var Trick $trick */
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        if ($trick == null) {
            throw $this->createNotFoundException($this->translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        /** @var Video $video */
        $video = $this->videoRepository->findOneBy(['uuid' => $uuid]);
        if ($video == null) {
            throw $this->createNotFoundException($this->translator->trans('exceptions.not_found', [], 'exceptions'));
        }

        $trick->removeVideo($video);
        $this->trickRepository->save($trick, true);
        return $this->redirectToRoute('app_trick_update', [
            'slug' => $slug
        ]);
    }
}
