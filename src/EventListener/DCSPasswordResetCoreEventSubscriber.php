<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\EventListener;

use DCS\PasswordReset\CoreBundle\DCSPasswordResetCoreEvents;
use DCS\PasswordReset\CoreBundle\Event\ResetRequestEvent;
use DCS\PasswordReset\Persistence\ORMBundle\DCSPasswordResetPersistenceORMEvents;
use DCS\PasswordReset\Persistence\ORMBundle\Event\ResetRequestSaveEvent;
use DCS\PasswordReset\Persistence\ORMBundle\Manager\Save;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DCSPasswordResetCoreEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var Save
     */
    private $save;

    /**
     * DCSPasswordResetCoreEventSubscriber constructor.
     *
     * @param Save $save
     */
    public function __construct(Save $save)
    {
        $this->save = $save;
    }

    public static function getSubscribedEvents()
    {
        return [
            DCSPasswordResetCoreEvents::SAVE_RESET_REQUEST => 'persistResetRequest',
        ];
    }

    public function persistResetRequest(ResetRequestEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $resetRequest = $event->getResetRequest();
        call_user_func($this->save, $resetRequest);

        $eventDispatcher->dispatch(
            DCSPasswordResetPersistenceORMEvents::RESET_REQUEST_PERSISTED,
            new ResetRequestSaveEvent($resetRequest, $this->save)
        );
    }
}