<?php

namespace App\EventListener;

use App\Entity\Picture;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Uid\Uuid;

class PictureListener
{
    public function prePersist(Picture $picture, LifecycleEventArgs $args): void
    {
        $picture->setUuid(Uuid::v4());
    }
}
