<?php

namespace App\EventListener;

use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;

class TrickListener
{
    public function __construct(private readonly Security $security, private readonly SluggerInterface $slugger)
    {
    }

    public function prePersist(Trick $trick, LifecycleEventArgs $args): void
    {
        if ($this->security->getUser()) {
            /** @var User $user */
            $user = $this->security->getUser();
            $trick->setUser($user);
        }
        $trick->setSlug($this->slugger->slug($trick->getName()));
        $trick->setCreatedAt(new \DateTimeImmutable());
    }

    public function preUpdate(Trick $trick, LifecycleEventArgs $args): void
    {
        $trick->setSlug($this->slugger->slug($trick->getName()));
        $trick->setUpdatedAt(new \DateTimeImmutable());
    }
}
