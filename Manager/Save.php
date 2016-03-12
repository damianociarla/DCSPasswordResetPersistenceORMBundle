<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Manager;

use DCS\PasswordReset\CoreBundle\Model\ResetRequestInterface;
use Doctrine\ORM\EntityManagerInterface;

class Save
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Save constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Save user instance to database
     *
     * @param ResetRequestInterface $resetRequest
     * @param bool $flush Flag to flush all changes
     */
    public function __invoke(ResetRequestInterface $resetRequest, $flush = true)
    {
        $this->entityManager->persist($resetRequest);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}