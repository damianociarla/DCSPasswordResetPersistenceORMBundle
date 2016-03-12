<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Repository;

use DCS\PasswordReset\CoreBundle\Repository\ResetRequestRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class ResetRequestRepository extends EntityRepository implements ResetRequestRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findAllNotUsedByUser($user)
    {
        return $this->findBy([
            'user' => $user,
            'usedAt' => null
        ]);
    }

    /**
     * @inheritDoc
     */
    public function findLatestNotUsedByUser($user)
    {
        $criteria = [
            'user' => $user,
            'usedAt' => null
        ];

        $orderBy = [
            'createdAt' => 'DESC'
        ];

        $resetRequests = $this->findBy($criteria, $orderBy, 1);

        if (count($resetRequests)) {
            return $resetRequests[0];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function findOneByToken($token)
    {
        return $this->findOneBy([
            'token' => $token
        ]);
    }
}