<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests\EventListener;

use DCS\PasswordReset\CoreBundle\DCSPasswordResetCoreEvents;
use DCS\PasswordReset\CoreBundle\Event\ResetRequestEvent;
use DCS\PasswordReset\CoreBundle\Model\ResetRequestInterface;
use DCS\PasswordReset\Persistence\ORMBundle\EventListener\DCSPasswordResetCoreEventSubscriber;
use DCS\PasswordReset\Persistence\ORMBundle\Manager\Save;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DCSPasswordResetCoreEventSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $saver = $this->getMockBuilder(Save::class)
            ->disableOriginalConstructor()
            ->getMock();

        new DCSPasswordResetCoreEventSubscriber($saver);
    }

    public function testGetSubscribedEventsMethod()
    {
        $events = DCSPasswordResetCoreEventSubscriber::getSubscribedEvents();

        $this->assertCount(1, $events);
        $this->assertArrayHasKey(DCSPasswordResetCoreEvents::SAVE_RESET_REQUEST, $events);
        $this->assertEquals('persistResetRequest', $events[DCSPasswordResetCoreEvents::SAVE_RESET_REQUEST]);
    }

    public function testPersistResetRequestMethod()
    {
        $resetRequest = $this->getMockBuilder(ResetRequestInterface::class)->getMock();

        $resetRequestEvent = new ResetRequestEvent($resetRequest);

        $saver = $this->getMockBuilder(Save::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $saver->expects($this->once())
            ->method('__invoke')
            ->with($resetRequest);

        $eventDispatcher = $this->getMockBuilder(EventDispatcherInterface::class)
            ->getMock();

        $eventDispatcher->expects($this->once())
            ->method('dispatch');

        $subscriber = new DCSPasswordResetCoreEventSubscriber($saver);
        $subscriber->persistResetRequest($resetRequestEvent, DCSPasswordResetCoreEvents::SAVE_RESET_REQUEST, $eventDispatcher);
    }
}