<?php
declare(strict_types=1);

namespace WebUser\Form;

use Core\Lib\Form\CaptchaResolver;
use Zend\Filter\StringTrim;
use Zend\Form\Element\Captcha;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;

/**
 * Class RegisterForm
 * @package WebUser\Form
 */
final class RegisterForm extends Form implements InputFilterProviderInterface
{
    public static function getForm() : Form
    {
        $form = new self();

        $form->add([
            'name'      => 'email',
            'options'   => [
                'label' => 'Email',
            ],
            'type'      => Email::class
        ]);

        $form->add([
            'name'      => 'password',
            'options'   => [
                'label' => 'Password'
            ],
            'type'      => Password::class,
        ]);

        $form->add([
            'name'      => 'password_confirm',
            'options'   => [
                'label' => 'Password Confirmation'
            ],
            'type'      => Password::class
        ]);

        $form->add([
            'name'          => 'captcha',
            'options'       => [
                'label'     => 'Please verify are you human?',
                'captcha'   => CaptchaResolver::getCaptchaInstance()
            ],
            'type'          => Captcha::class
        ]);

        $form->add([
            'name'          => 'submit',
            'attributes'   => [
                'value'     => 'Register'
            ],
            'type'          => Submit::class
        ]);

        return $form;
    }

    public function getInputFilterSpecification()
    {
        return [
            'email' => [
                'required' => 'true',
                'filters' => [
                    ['name' => StringTrim::class]
                ],
                'validators' => [
                    new EmailAddress()
                ]
            ],
            'password' => [
                'required' => true,
            ],
            'password_confirm' => [
                'required' => true,
                'validators' => [
                    new Identical('password')
                ],
            ],
            'g-recaptcha-response' => [
                'required' => false,
            ],

            'captcha' => [
                'required' => false,
            ]
        ];
    }
}
