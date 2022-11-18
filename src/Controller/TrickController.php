<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickController extends AbstractController
{
    #[Route('/trick', name: 'app_trick')]
    public function index(TranslatorInterface $translator): Response
    {
        $hello = $translator->trans('snow_trick.hello');
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
            'hello' => $hello
        ]);
    }
}
