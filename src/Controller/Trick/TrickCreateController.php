<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use App\UploadService\UploadPictureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickCreateController extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TranslatorInterface $translator,
        private readonly UploadPictureService $uploadPictureService
    ) {
    }

    #[Route('/trick/nouveau', name: 'app_trick_create')]
    public function __invoke(Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('info', $this->translator->trans('flashes.info.no-login', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        $trick = new Trick();
        $form = $this->createForm(TrickFormType::class, $trick);
        $form->handleRequest($request);
        if (
            $form->isSubmitted() &&
            $form->isValid() &&
            $this->uploadPictureService->noEmptyFieldPicture($trick, $form)
        ) {
            $this->uploadPictureService->handleUploadPicture($trick);
            $this->trickRepository->save($trick, true);
            $this->addFlash('success', $this->translator->trans('flashes.success.add_trick', [], 'flashes'));
            return $this->redirectToRoute('app_trick', ['slug' => $trick->getSlug()]);
        }
        return $this->render('trick/trick_create/index.html.twig', [
            'add_header' => true,
            'fix_footer' => true,
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }
}
