<?php

namespace WebUser;

use Core\Middleware\CaptchaResolverMiddleware;
use Core\Middleware\ValidateCsrfTokenMiddleware;
use Theme\Helper\Path;
use WebUser\Action\WebUserLoginPageAction;
use WebUser\Action\WebUserRegisterPageAction;
use WebUser\Container\Action\WebUserLoginPageFactory;
use WebUser\Container\Action\WebUserRegisterPageFactory;
use WebUser\Container\Lib\Auth\AuthFactory;
use WebUser\Container\TableGateway\WebUserTableGatewayFactory;
use WebUser\Event\AfterWebUserRegisterEvent;
use WebUser\Lib\Auth\AuthInterface;
use WebUser\Listener\SendRegistrationConfirmationEmail;
use WebUser\TableGateway\WebUserTableGateway;
use WebUser\TableGateway\WebUserTableGatewayInterface;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Session\SessionMiddleware;

/**
 * The configuration provider for the WebUser module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    public const NAMESPACE = 'web-user';
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies'  => $this->getDependencies(),
            'templates'     => $this->getTemplates(),
            'events'        => $this->getEvents(),
            'routes'        => $this->getRoutes(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                WebUserTableGateway::class          => WebUserTableGateway::class
            ],
            'factories'  => [
                WebUserLoginPageAction::class       => WebUserLoginPageFactory::class,
                WebUserRegisterPageAction::class    => WebUserRegisterPageFactory::class,
                AuthInterface::class                => AuthFactory::class,
                WebUserTableGatewayInterface::class => WebUserTableGatewayFactory::class
            ],
        ];
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return [
            AfterWebUserRegisterEvent::class => [
                [
                    'listener'  => SendRegistrationConfirmationEmail::class,
                    'method'    => '__invoke',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getRoutes() : array
    {
        return [
            [
                'path'          => '/login',
                'middleware'    => [
                    SessionMiddleware::class,
                    FlashMessageMiddleware::class,
                    CsrfMiddleware::class,
                    ValidateCsrfTokenMiddleware::class,
                    WebUserLoginPageAction::class
                ],
                'methods'       => ['GET', 'POST'],
                'name'          => 'login'
            ],
            [
                'path'          => '/register',
                'middleware'    => [
                    SessionMiddleware::class,
                    FlashMessageMiddleware::class,
                    CsrfMiddleware::class,
                    ValidateCsrfTokenMiddleware::class,
                    CaptchaResolverMiddleware::class,
                    WebUserRegisterPageAction::class
                ],
                'methods'       => ['GET', 'POST'],
                'name'          => 'register'
            ]
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                self::NAMESPACE    => [Path::getThemeDir() . '/' . self::NAMESPACE],
            ],
        ];
    }
}
