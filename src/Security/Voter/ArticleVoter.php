<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        $supportsAttribute = in_array($attribute, ['ARTICLE_CREATE', 'ARTICLE_READ', 'ARTICLE_EDIT', 'ARTICLE_DELETE']);
        $supportsSubject = $subject instanceof Article;

        return $supportsAttribute && $supportsSubject;
    }

    
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'ARTICLE_READ':
                if($this->security->isGranted('ROLE_ADMIN') || $subject->getUser() == $user){
                    return true;
                }
                break;
            case 'ARTICLE_CREATE':
                if($this->security->isGranted('ROLE_USER')){
                    return true;
                }
                break;
            case 'ARTICLE_EDIT':
                if($this->security->isGranted('ROLE_ADMIN') || $subject->getUser() == $user){
                    return true;
                }
                break;
            case 'ARTICLE_DELETE':
                if($this->security->isGranted('ROLE_ADMIN') || $subject->getUser() == $user){
                    return true;
                }
                break;
        }

        return false;
    }
}