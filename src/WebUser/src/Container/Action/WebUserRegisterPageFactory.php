<?php
declare(strict_types=1);

namespace WebUser\Container\Action;

use Psr\Container\ContainerInterface;
use WebUser\Action\WebUserRegisterPageAction;
use WebUser\TableGateway\WebUserTableGatewayInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

final class WebUserRegisterPageFactory
{
    public function __invoke(ContainerInterface $container) : WebUserRegisterPageAction
    {
        return new WebUserRegisterPageAction(
            $container->get(RouterInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get(WebUserTableGatewayInterface::class),
            $container->get(EventManagerInterface::class)
        );
    }
}
