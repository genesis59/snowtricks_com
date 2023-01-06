<?php

namespace App\Paginator;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PaginatorService
{
    private int $trickPerPage;
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly ParameterBagInterface $parameterBag,
    ) {
        $this->trickPerPage = intval($this->parameterBag->get('trick_per_page'));
    }

    /**
     * @param mixed $page
     * @return Trick[]
     */
    public function paginateTrick(mixed $page): array
    {
        $limit = $this->trickPerPage * intval($page);
        return $this->trickRepository->findBy([], null, $limit);
    }

    public function trickPageMax(): int
    {
        if ($this->trickPerPage !== 0) {
            return intval(ceil($this->trickRepository->count([]) / $this->trickPerPage));
        }
        return 1;
    }
}
