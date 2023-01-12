<?php

namespace App\EventListener;

use App\Entity\Comment;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Uid\Uuid;

class CommentListener
{
    public function __construct()
    {
    }
    public function prePersist(Comment $comment, LifecycleEventArgs $args): void
    {
        $comment->setUuid(Uuid::v4());
        $comment->setCreatedAt(new \DateTimeImmutable());
    }
}
