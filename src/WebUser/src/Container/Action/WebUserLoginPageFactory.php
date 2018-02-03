<?php
declare(strict_types=1);


namespace WebUser\Container\Action;


use Psr\Container\ContainerInterface;
use WebUser\Action\WebUserLoginPageAction;
use WebUser\Container\Lib\Auth\AuthFactory;
use WebUser\TableGateway\WebUserTableGatewayInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class WebUserLoginPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new WebUserLoginPageAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(AuthFactory::class),
            $container->get(WebUserTableGatewayInterface::class)
        );
    }
}
