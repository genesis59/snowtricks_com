<?php

namespace App\Controller\Trick;

use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use App\UploadService\UploadPictureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickUpdateController extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly UploadPictureService $uploadPictureService,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/trick/update/{slug}', name: 'app_trick_update')]
    public function __invoke(string $slug, Request $request): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickFormType::class, $trick);
        $form->handleRequest($request);
        if (
            $form->isSubmitted() &&
            $form->isValid() &&
            $this->uploadPictureService->noEmptyFieldPicture($trick, $form)
        ) {
            $this->uploadPictureService->handleUploadPicture($trick);
            $this->trickRepository->save($trick, true);
            $this->addFlash('success', $this->translator->trans('flashes.success.update_trick', [], 'flashes'));
            return $this->redirectToRoute('app_trick', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/trick_update/index.html.twig', [
            'trick' => $trick,
            'add_header' => true,
            'fix_footer' => true,
            'form' => $form->createView()
        ]);
    }
}
