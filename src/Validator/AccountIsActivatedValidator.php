<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AccountIsActivatedValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AccountIsActivated) {
            throw new UnexpectedTypeException($constraint, AccountIsActivated::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (
            $this->userRepository->findOneBy(['email' => $value]) &&
            !$this->userRepository->findOneBy(['email' => $value])->isIsActivated()
        ) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ email }}', $value)
                ->addViolation();
        }
    }
}
