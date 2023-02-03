<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use App\UploadService\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickCreateController extends AbstractController
{
    #[Route('/trick/nouveau', name: 'app_trick_create')]
    public function __invoke(
        Request $request,
        TrickRepository $trickRepository,
        TranslatorInterface $translator,
        UploadService $uploadService
    ): Response {
        if (!$this->getUser()) {
            $this->addFlash('info', $translator->trans('flashes.info.no-login', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        $trick = new Trick();

        $form = $this->createForm(TrickFormType::class, $trick);
        $form->handleRequest($request);

        // Gère l'erreur si le fichier upload dépasse 8mo limite de php.ini upload_max_size
        if (count($form->getErrors()) > 0) {
            /** @var FormError $error */
            foreach ($form->getErrors() as $error) {
                $this->addFlash('danger', $error->getMessage() . $translator->trans(
                    'validators.image.max_size_message',
                    [],
                    'validators'
                ));
            }
            return $this->redirectToRoute('app_trick_create');
        }
        if (
            $form->isSubmitted() &&
            $form->isValid() &&
            $uploadService->noEmptyFieldPicture($trick, $form)
        ) {
            $uploadService->handleUploadPicture($trick);
            $trickRepository->save($trick, true);
            $this->addFlash('success', $translator->trans('flashes.success.add_trick', [], 'flashes'));
            return $this->redirectToRoute('app_trick', ['slug' => $trick->getSlug()]);
        }
        return $this->render('trick/trick_create/index.html.twig', [
            'add_header' => true,
            'fix_footer' => true,
            'trick' => $trick,
            'form' => $form->createView(),
            'flashes' => true
        ]);
    }
}
