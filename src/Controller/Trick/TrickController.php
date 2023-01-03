<?php

namespace App\Controller\Trick;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    #[Route('/trick/{slug}', name: 'app_trick')]
    public function __invoke(
        string $slug,
        TrickRepository $trickRepository
    ): Response {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        return $this->render('trick/trick/index.html.twig', [
            'trick' => $trick,
            'add_header' => true,
            'fix_footer' => true
        ]);
    }
}
