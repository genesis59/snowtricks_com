<?php

namespace App\EventListener;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Uid\Uuid;

class CommentListener
{
    public function __construct(private readonly Security $security)
    {
    }
    public function prePersist(Comment $comment, LifecycleEventArgs $args): void
    {
        if ($this->security->getUser()) {
            /** @var User $user */
            $user = $this->security->getUser();
            $comment->setUser($user);
        }
        $comment->setUuid(Uuid::v4());
        $comment->setCreatedAt(new \DateTimeImmutable());
    }
}
