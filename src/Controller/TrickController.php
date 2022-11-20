<?php

namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $tricks = $doctrine->getRepository(Trick::class)->findAll();
        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}
