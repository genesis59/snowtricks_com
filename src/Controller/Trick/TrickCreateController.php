<?php

namespace App\Controller\Trick;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickCreateController extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TranslatorInterface $translator
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
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile[] $pictures */
            $pictures = $form->get('addPictures')->getData();

            foreach ($pictures as $picture) {
                $fileName = md5(uniqid()) . '.' . $picture->getExtension();
                $picture->move(strval($this->getParameter('picture_trick_upload_directory')), $fileName);
                $pict = new Picture();
                $pict->setUuid(Uuid::v4());
                $pict->setTrick($trick);
                $pict->setFileName($fileName);
                $trick->addPicture($pict);
            }
            $this->trickRepository->save($trick, true);
            $this->addFlash('success', $this->translator->trans('flashes.success.add_trick', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        return $this->render('trick/trick_create/index.html.twig', [
            'add_header' => true,
            'fix_footer' => true,
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }
}
