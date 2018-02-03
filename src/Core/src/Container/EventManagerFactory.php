<?php
declare(strict_types=1);

namespace Core\Container;

use Psr\Container\ContainerInterface;
use WebUser\Event\AfterWebUserRegisterEvent;
use WebUser\Listener\SendRegistrationConfirmationEmail;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\LazyListener;

/**
 * Class EventManagerFactory
 * @package Core\Container
 */
final class EventManagerFactory
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container) : EventManagerInterface
    {
        $events = $container->get('config')['events'];

        $eventManager = new EventManager();

        foreach ($events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $eventManager->attach($event, new LazyListener($listener, $container));
            }
        }

        return $eventManager;
    }
}
