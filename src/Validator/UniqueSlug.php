<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Contracts\Translation\TranslatorInterface;

#[\Attribute]
class UniqueSlug extends Constraint
{
    public string $message;

    public function __construct(string $message = "Désolé la valeur {{ value }} n'est plus disponible.")
    {
        parent::__construct();
        $this->message = $message;
    }
}
