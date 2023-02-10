<?php

namespace App\Validator;

use App\Repository\TrickRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueSlugValidator extends ConstraintValidator
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly SluggerInterface $slugger
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueSlug) {
            throw new UnexpectedTypeException($constraint, UniqueSlug::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if ($this->trickRepository->findOneBy(['name' => $value])) {
            return;
        }
        if ($this->trickRepository->findOneBy(['slug' => $this->slugger->slug($value)])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
