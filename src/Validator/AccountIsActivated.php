<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class AccountIsActivated extends Constraint
{
    public string $message = 'validators.custom.account_is_activated';
}
