<?php
declare(strict_types=1);

namespace Core\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Expressive\Csrf\CsrfGuardInterface;
use Zend\Expressive\Csrf\CsrfMiddleware;

/**
 * Class ValidateCsrfTokenMiddleware
 * @package Core\Middleware
 */
final class ValidateCsrfTokenMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($request->getMethod() !== 'GET') {
            /** @var CsrfGuardInterface $guard */
            $guard = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
            $data = $request->getParsedBody();
            $token = $data['__csrf'] ?? '';

            if (! $guard->validateToken($token)) {
                return new EmptyResponse(403);
            }
        }


        return $delegate->process($request);
    }
}
