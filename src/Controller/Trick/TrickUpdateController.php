<?php

namespace App\Controller\Trick;

use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use App\UploadService\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickUpdateController extends AbstractController
{
    #[Route('/trick/update/{slug}', name: 'app_trick_update')]
    public function __invoke(
        string $slug,
        Request $request,
        TrickRepository $trickRepository,
        UploadService $uploadService,
        TranslatorInterface $translator
    ): Response {
        if (!$this->getUser()) {
            $this->addFlash('info', $translator->trans('flashes.info.no-login', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickFormType::class, $trick);
        $form->handleRequest($request);
        if (
            $form->isSubmitted() &&
            $form->isValid() &&
            $uploadService->noEmptyFieldPicture($trick, $form)
        ) {
            $uploadService->handleUploadPicture($trick);
            $trickRepository->save($trick, true);
            $this->addFlash('success', $translator->trans('flashes.success.update_trick', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        return $this->render('trick/trick_update/index.html.twig', [
            'trick' => $trick,
            'add_header' => true,
            'fix_footer' => true,
            'form' => $form->createView(),
            'flashes' => true
        ]);
    }
}
