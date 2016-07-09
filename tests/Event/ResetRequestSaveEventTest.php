<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests\Event;

use DCS\PasswordReset\CoreBundle\Model\ResetRequestInterface;
use DCS\PasswordReset\Persistence\ORMBundle\Event\ResetRequestSaveEvent;
use DCS\PasswordReset\Persistence\ORMBundle\Manager\Save;

class ResetRequestSaveEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResetRequestSaveEvent
     */
    private $event;

    public function setUp()
    {
        $resetRequest = $this->getMockBuilder(ResetRequestInterface::class)->getMock();

        $saver = $this->getMockBuilder(Save::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $this->event = new ResetRequestSaveEvent($resetRequest, $saver);
    }

    public function testGetResetRequestMethod()
    {
        $this->assertInstanceOf(ResetRequestInterface::class, $this->event->getResetRequest());
    }

    public function testGetSaveMethod()
    {
        $this->assertInstanceOf(Save::class, $this->event->getSave());
    }
}