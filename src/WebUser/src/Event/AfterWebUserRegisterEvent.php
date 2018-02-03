<?php
declare(strict_types=1);

namespace WebUser\Event;

use Zend\EventManager\Event;

/**
 * Class AfterWebUserRegisterEvent
 * @package WebUser\Event
 */
final class AfterWebUserRegisterEvent extends Event
{
    /**
     * AfterWebUserRegisterEvent constructor.
     * @param array $user
     */
    public function __construct(array $user)
    {
        parent::__construct(__CLASS__, null, ['user' => $user]);
    }
}
