<?php

namespace App\Controller\Home;

use App\Paginator\PaginatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function __invoke(Request $request, PaginatorService $paginatorService): Response
    {

        $page = $request->query->get('page') ?? 1;
        $tricks = $paginatorService->paginateTrick($page);
        if ($request->query->get('addByStim')) {
            return $this->render('home/_home.html.twig', [
                'tricks' => $tricks,
                'page' => $request->query->get('page')
            ]);
        }
        $pageMax = $paginatorService->trickPageMax();

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'countTricks' => $paginatorService->countTricks(),
            'page' => $page,
            'page_max' => $pageMax,
            'add_header' => true,
            'fix_footer' => false
        ]);
    }
}
