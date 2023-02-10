<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Contracts\Translation\TranslatorInterface;

#[\Attribute]
class AccountIsActivated extends Constraint
{
    public string $message;

    public function __construct(string $message = "Désolé l'adresse {{ email }} n'est pas encore active.")
    {
        parent::__construct();
        $this->message = $message;
    }
}
