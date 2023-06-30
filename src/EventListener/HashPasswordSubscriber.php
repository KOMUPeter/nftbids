<?php

namespace App\EventListener;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordSubscriber implements EventSubscriberInterface
{
    protected UserPasswordHasherInterface $hasher;

    //inject the service of password hashing
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    // define thewhich method will be used during an event
    public static function getSubscribedEvents(): array
    {
        // Notez qu'aucune priorité n'est définie (c'est le cas le plus courant, pour moi).
        // Ceci est équivalent à une priorité de 0
        // Notez également que l'on utilise le FQCN des événement, et non une constante. Les deux fonctionnent ;)
        return [
            BeforeEntityPersistedEvent::class => ['updateUserPassword'],
            BeforeEntityUpdatedEvent::class => ['updateUserPassword'],
        ];
    }

    /**
     * @param BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent $event
     */
    public function updateUserPassword($event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof User || empty($entity->getPlainPassword())) {
            return;
        }

        // On définit le nouveau mot de passe, en hashant la propriété plainPassword (temporaire)
        $entity->setPassword(
            $this->hasher->hashPassword($entity, $entity->getPlainPassword())
        );
    }
}