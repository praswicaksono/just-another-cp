<?php
declare(strict_types=1);


namespace Core\Middleware;


use Core\Lib\Form\CaptchaResolver;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Captcha\AdapterInterface;

/**
 * Class CaptchaResolverMiddleware
 * @package Core\Middleware
 */
final class CaptchaResolverMiddleware implements MiddlewareInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * CaptchaResolverMiddleware constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        CaptchaResolver::setCaptchaInstance($this->adapter);
        return $delegate->process($request);
    }
}
