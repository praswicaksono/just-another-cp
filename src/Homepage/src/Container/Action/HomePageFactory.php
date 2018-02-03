<?php
declare(strict_types=1);


namespace Homepage\Container\Action;

use GameServer\Lib\GameServerStatusInterface;
use Homepage\Action\HomePageAction;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class HomePageFactory
 * @package Homepage\Container\Action
 */
final class HomePageFactory
{
    /**
     * @param ContainerInterface $container
     * @return HomePageAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        return new HomePageAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(GameServerStatusInterface::class)
        );
    }
}
