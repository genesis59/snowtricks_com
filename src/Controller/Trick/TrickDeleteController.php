<?php

namespace App\Controller\Trick;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickDeleteController extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/trick/delete/{slug}', name: 'app_trick_delete')]
    public function __invoke(string $slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        if ($trick === null) {
            $this->addFlash('danger', $this->translator->trans('flashes.error.delete_trick', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        foreach ($trick->getPicture() as $picture) {
            if (
                is_string($this->getParameter('picture_trick_upload_directory'))
                && is_string($picture->getFileName())
            ) {
                $fileName = $this->getParameter('picture_trick_upload_directory') . $picture->getFileName();
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
            }
        }
        $this->addFlash('success', $this->translator->trans('flashes.success.delete_trick', [], 'flashes'));
        $this->trickRepository->remove($trick, true);
        return $this->redirectToRoute('home');
    }
}
