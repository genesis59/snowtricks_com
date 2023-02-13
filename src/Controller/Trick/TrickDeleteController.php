<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickDeleteController extends AbstractController
{
    #[Route('/trick/delete/{slug}', name: 'app_trick_delete')]
    public function __invoke(
        string $slug,
        TrickRepository $trickRepository,
        TranslatorInterface $translator,
        Request $request
    ): Response {
        if (!$this->getUser()) {
            $this->addFlash('info', $translator->trans('flashes.info.no-login', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        /** @var Trick $trick */
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        if ($trick == null) {
            $this->addFlash('danger', $translator->trans('flashes.error.delete_trick', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        foreach ($trick->getPictures() as $picture) {
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
        $this->addFlash('success', $translator->trans('flashes.success.delete_trick', [], 'flashes'));
        $trickRepository->remove($trick, true);
        return $this->redirectToRoute('home', [
            'page' => $request->query->get('page') ?? 1
        ]);
    }
}
