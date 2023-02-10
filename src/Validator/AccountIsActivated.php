<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Contracts\Translation\TranslatorInterface;

#[\Attribute]
class AccountIsActivated extends Constraint
{
    public string $message = "";

    public function __construct(private readonly TranslatorInterface $translator)
    {
        parent::__construct();
        $this->message = $this->translator->trans('validators.custom.account_is_activated', [], 'validators');
    }
}
