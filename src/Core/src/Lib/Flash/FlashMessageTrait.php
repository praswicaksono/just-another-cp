<?php
declare(strict_types=1);

namespace Core\Lib\Flash;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Flash\FlashMessageMiddleware;

/**
 * Trait FlashMessageTrait
 * @package Core\Lib
 */
trait FlashMessageTrait
{
    /**
     * @param ServerRequestInterface $request
     * @return FlashMessagesInterface
     */
    private function getFlashFromRequest(ServerRequestInterface $request) : FlashMessagesInterface
    {
        $flash = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);

        if (is_null($flash)) {
            throw new \BadMethodCallException('Flash session has not initialized yet');
        }

        return new FlashMessages($flash);
    }
}