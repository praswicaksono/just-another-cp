<?php
declare(strict_types=1);

namespace WebUser\Form;

use Zend\Filter\StringTrim;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;

/**
 * Class LoginForm
 * @package WebUser\Form
 */
final class LoginForm extends Form implements InputFilterProviderInterface
{
    /**
     * @return FormInterface
     */
    public static function getForm() : FormInterface
    {
        $form = new self();

        $form->add([
            'name'      => 'email',
            'options'   => [
                'label' => 'Your Email',
            ],
            'type'      => Email::class
        ]);

        $form->add([
            'name'      => 'password',
            'options'   => [
                'label' => 'Password',
            ],
            'type'      => Password::class
        ]);

        $form->add([
            'name'          => 'submit',
            'attributes'   => [
                'value'     => 'Login'
            ],
            'type'          => Submit::class
        ]);

        return $form;
    }

    /**
     * @return array
     */
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
            'password_confirmation' => [
                'required' => true,
                'validators' => [
                    new Identical('password')
                ],
            ],
        ];
    }
}
