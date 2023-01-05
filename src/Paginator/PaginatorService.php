<?php

namespace App\Paginator;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PaginatorService
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    /**
     * @param mixed $page
     * @return Trick[]
     */
    public function paginateTrick(mixed $page): array
    {
        $limit = intval($this->parameterBag->get('trickPerPage')) * intval($page);
        return $this->trickRepository->findBy([], null, $limit);
    }

    public function trickPageMax(): int
    {
        if (intval($this->parameterBag->get('trickPerPage')) !== 0) {
            return intval(ceil($this->trickRepository->count([]) / intval($this->parameterBag->get('trickPerPage'))));
        }
        return 1;
    }
}
