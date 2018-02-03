<?php
declare(strict_types=1);

namespace Core\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebUser\TableGateway\WebUserTableGatewayInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionMiddleware;

/**
 * Class UserSessionMiddleware
 * @package Core\Middleware
 */
final class UserSessionMiddleware implements MiddlewareInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var WebUserTableGatewayInterface
     */
    private $tableGateway;

    /**
     * UserSessionMiddleware constructor.
     * @param RouterInterface $router
     * @param WebUserTableGatewayInterface $tableGateway
     */
    public function __construct(RouterInterface $router, WebUserTableGatewayInterface $tableGateway)
    {
        $this->router = $router;
        $this->tableGateway = $tableGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /** @var SessionInterface $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

        $user = $this->tableGateway->select(['id' => $session->get('web_user_id')])->current();

        if ($user === null) {
            return new RedirectResponse($this->router->generateUri('login'));
        }

        return $delegate->process($request->withAttribute('user', $user));
    }
}
