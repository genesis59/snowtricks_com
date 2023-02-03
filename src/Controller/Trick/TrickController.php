<?php

namespace App\Controller\Trick;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Paginator\PaginatorService;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickController extends AbstractController
{
    #[Route('/trick/detail/{slug}', name: 'app_trick')]
    public function __invoke(
        string $slug,
        TrickRepository $trickRepository,
        CommentRepository $commentRepository,
        Request $request,
        PaginatorService $paginatorService,
        TranslatorInterface $translator
    ): Response {

        $page = $request->query->get('page') ?? 1;
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        if (!$trick) {
            throw $this->createNotFoundException($translator->trans('exceptions.not_found', [], 'exceptions'));
        }
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->getUser()) {
                $this->addFlash('info', $translator->trans('flashes.info.no-login', [], 'flashes'));
                return $this->redirectToRoute('home');
            }
            $comment->setTrick($trick);
            $commentRepository->save($comment, true);
            $comment = new Comment();
            $form = $this->createForm(CommentFormType::class, $comment);
        }
        $comments = $paginatorService->paginateComment($trick, $page);
        return $this->render('trick/trick_detail/index.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'form' => $form->createView(),
            'add_header' => true,
            'fix_footer' => true,
            'page' => $page,
            'flashes' => true
        ]);
    }
}
