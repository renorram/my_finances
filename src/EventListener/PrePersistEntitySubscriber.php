<?php declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Interfaces\CreatedAt;
use App\Entity\Interfaces\UpdatedAt;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class PrePersistEntitySubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof CreatedAt) {
            return;
        }

        $now = new DateTime();
        $entity->setCreatedAt($now);

        if (!$entity instanceof UpdatedAt) {
            return;
        }

        $entity->setUpdatedAt($now);
    }
}
