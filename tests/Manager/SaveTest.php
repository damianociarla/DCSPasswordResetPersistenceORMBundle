<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests\Manager;

use DCS\PasswordReset\CoreBundle\Model\ResetRequestInterface;
use DCS\PasswordReset\Persistence\ORMBundle\Manager\Save;
use Doctrine\ORM\EntityManager;

class SaveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $em;

    private $resetRequestInterface;

    protected function setUp()
    {
        $this->em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['persist','flush'])
            ->getMock();

        $this->resetRequestInterface = $this->getMockBuilder(ResetRequestInterface::class)->getMock();
    }

    public function testSaveWithoutFlush()
    {
        $this->em->expects($this->once())->method('persist');
        $this->em->expects($this->exactly(0))->method('flush');

        $save = new Save($this->em);
        $save($this->resetRequestInterface, false);
    }

    public function testSaveWithFlush()
    {
        $this->em->expects($this->once())->method('persist');
        $this->em->expects($this->once())->method('flush');

        $save = new Save($this->em);
        $save($this->resetRequestInterface, true);
    }
}