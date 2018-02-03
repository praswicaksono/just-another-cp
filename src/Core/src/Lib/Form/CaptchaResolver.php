<?php
declare(strict_types=1);


namespace Core\Lib\Form;

use Zend\Captcha\AdapterInterface;
use Zend\Captcha\Dumb;

/**
 * Class CaptchaResolver
 * @package Core\Lib\Form
 */
final class CaptchaResolver
{
    /**
     * @var AdapterInterface
     */
    private static $captcha;

    /**
     * @param AdapterInterface $captcha
     */
    public static function setCaptchaInstance(AdapterInterface $captcha)
    {
        self::$captcha = $captcha;
    }

    /**
     * @return AdapterInterface
     */
    public static function getCaptchaInstance() : AdapterInterface
    {
        if (self::$captcha === null) {
            return new Dumb();
        }

        return self::$captcha;
    }
}
