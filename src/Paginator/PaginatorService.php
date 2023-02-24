<?php

namespace App\Paginator;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PaginatorService
{
    private int $trickPerPage;
    private int $commentPerPage;

    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly CommentRepository $commentRepository,
        private readonly ParameterBagInterface $parameterBag,
    ) {
        $this->trickPerPage = intval($this->parameterBag->get('trick_per_page'));
        $this->commentPerPage = intval($this->parameterBag->get('comment_per_page'));
    }

    /**
     * @param mixed $page
     * @return Trick[]
     */
    public function paginateTrick(mixed $page): array
    {
        $limit = $this->trickPerPage * intval($page);
        return $this->trickRepository->findBy([], ['createdAt' => "DESC"], $limit);
    }

    public function trickPageMax(): int
    {
        if ($this->trickPerPage !== 0) {
            return intval(ceil($this->trickRepository->count([]) / $this->trickPerPage));
        }
        return 1;
    }

    /**
     * @param Trick $trick
     * @param mixed $page
     * @return Comment[]
     */
    public function paginateComment(Trick $trick, mixed $page): array
    {
        $limit = $this->commentPerPage * intval($page);
        return $this->commentRepository->findBy(['trick' => $trick->getId()], ['createdAt' => "DESC"], $limit);
    }

    public function countTricks(): int
    {
        return $this->trickRepository->count([]);
    }
}
