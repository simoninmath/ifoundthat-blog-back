<?php

namespace App\Dto;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UserRegisterDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 100)]
        #[Assert\Email]
        public readonly string $email,

        #[Assert\PasswordStrength([
            'minScore' => PasswordStrength::STRENGTH_WEAK, // Weak password required
        ])]
        public readonly string $password
    ){}
}
