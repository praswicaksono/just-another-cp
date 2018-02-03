<?php
declare(strict_types=1);


namespace WebUser\ViewModel;

use Zend\Form\FormInterface;

/**
 * Class RegisterViewModel
 * @package WebUser\ViewModel
 */
final class RegisterViewModel
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var string
     */
    private $title;

    /**
     * LoginPageViewModel constructor.
     * @param array $data
     */
    private function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @param array $data
     * @return RegisterViewModel
     */
    public static function withArray(array $data)
    {
        return new self($data);
    }

    /**
     * @return FormInterface
     */
    public function getForm() : FormInterface
    {
        return $this->form;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }
}
