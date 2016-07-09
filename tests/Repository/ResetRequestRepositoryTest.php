<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests\Repository;

use DCS\PasswordReset\CoreBundle\Model\ResetRequestInterface;
use DCS\PasswordReset\Persistence\ORMBundle\Repository\ResetRequestRepository;
use DCS\User\CoreBundle\Model\User;
use DCS\User\CoreBundle\Model\UserInterface;

class ResetRequestRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFindAllNotUsedByUser()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();

        $repositoryMock = $this->getMockBuilder(ResetRequestRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findBy'])
            ->getMock();

        $repositoryMock->expects($this->once())
            ->method('findBy')
            ->with([
                'user' => $user,
                'usedAt' => null
            ]);

        $repositoryMock->findAllNotUsedByUser($user);
    }

    /**
     * @dataProvider getResetRequestNotUsedByUser
     */
    public function testFindLatestNotUsedByUser($user, $returnValues, $expected)
    {
        $repositoryMock = $this->getMockBuilder(ResetRequestRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findBy'])
            ->getMock();

        $repositoryMock->expects($this->once())
            ->method('findBy')
            ->with(
                [
                    'user' => $user,
                    'usedAt' => null
                ],
                [
                    'createdAt' => 'DESC'
                ],
                1
            )
            ->willReturn($returnValues);

        $this->assertEquals($expected, $repositoryMock->findLatestNotUsedByUser($user));
    }

    public function testFindOneByToken()
    {
        $token = 'xxx';

        $repositoryMock = $this->getMockBuilder(ResetRequestRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();

        $repositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with([
                'token' => $token,
            ]);

        $repositoryMock->findOneByToken($token);
    }

    public function getResetRequestNotUsedByUser()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $resetRequest = $this->getMockBuilder(ResetRequestInterface::class)->getMock();

        return [
            [
                $user, [], null
            ],
            [
                $user, [$resetRequest], $resetRequest
            ],
        ];
    }
}