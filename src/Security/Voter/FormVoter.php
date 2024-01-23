<?php

namespace App\Security\Voter;

use App\Entity\Form;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class FormVoter extends Voter
{
    public const CREATE = 'FORM_CREATE';

    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        $supportsAttribute = in_array($attribute, ['FORM_CREATE', 'FORM_READ', 'FORM_EDIT', 'FORM_DELETE']);
        $supportsSubject = $subject instanceof Form;

        return $supportsAttribute && $supportsSubject;
    }

    
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'FORM_READ':
                if($this->security->isGranted('ROLE_ADMIN') || $subject->getUser() == $user){
                    return true;
                }
                break;
            case 'FORM_EDIT':
                if($this->security->isGranted('ROLE_ADMIN') || $subject->getUser() == $user){
                    return true;
                }
                break;
            case 'FORM_DELETE':
                if($this->security->isGranted('ROLE_ADMIN') || $subject->getUser() == $user){
                    return true;
                }
                break;
        }

        return false;
    }
}
