<?php

namespace App\Controller\Home;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function __invoke(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findAll();
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'add_header' => true,
            'fix_footer' => false
        ]);
    }
}
