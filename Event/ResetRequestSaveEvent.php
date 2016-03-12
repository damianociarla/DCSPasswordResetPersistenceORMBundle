<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Event;

use DCS\PasswordReset\CoreBundle\Model\ResetRequestInterface;
use Symfony\Component\EventDispatcher\Event;

class ResetRequestSaveEvent extends Event
{
    /**
     * @var ResetRequestInterface
     */
    private $resetRequest;

    /**
     * @var callable
     */
    private $save;

    /**
     * ResetRequestSaveEvent constructor.
     *
     * @param ResetRequestInterface $resetRequest
     * @param callable $save
     */
    public function __construct(ResetRequestInterface $resetRequest, callable $save)
    {
        $this->resetRequest = $resetRequest;
        $this->save = $save;
    }

    /**
     * Get resetRequest
     *
     * @return ResetRequestInterface
     */
    public function getResetRequest()
    {
        return $this->resetRequest;
    }

    /**
     * Get save
     *
     * @return callable
     */
    public function getSave()
    {
        return $this->save;
    }
}