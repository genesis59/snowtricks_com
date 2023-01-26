<?php

namespace App\EventListener;

use App\Entity\Video;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Uid\Uuid;

class VideoListener
{
    public function prePersist(Video $video, LifecycleEventArgs $args): void
    {
        $video->setUuid(Uuid::v4());
    }
}
