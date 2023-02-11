<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueSlug extends Constraint
{
    public string $message = 'validators.custom.unique_slug';
}
