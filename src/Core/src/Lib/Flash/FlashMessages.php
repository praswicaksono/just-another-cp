<?php
declare(strict_types=1);


namespace Core\Lib\Flash;

use Zend\Expressive\Flash\FlashMessagesInterface as ZendFlashMessages;

final class FlashMessages implements FlashMessagesInterface
{
    /**
     * @var ZendFlashMessages
     */
    private $flash;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $old;

    /**
     * FlashMessages constructor.
     * @param ZendFlashMessages $flash
     */
    public function __construct(ZendFlashMessages $flash)
    {
        $this->flash = $flash;
        $this->errors = $flash->getFlash('errors', []);
        $this->old = $flash->getFlash('old', []);
    }

    /**
     * {@inheritdoc}
     */
    public function hasError(string $field): bool
    {
        return array_key_exists($field, $this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function hasErrors(): bool
    {
        return (count($this->errors) == 0) ? false : true;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * {@inheritdoc}
     */
    public function getError(string $field, bool $singleMessage = true)
    {
        if (! $this->hasError($field)) {
            return null;
        }

        $messages = $this->errors[$field];

        if (is_array($messages) && $singleMessage) {
            return array_shift($messages);
        }

        return $messages;
    }

    /**
     * {@inheritdoc}
     */
    public function old(): \ArrayAccess
    {
        $flash = $this->flash;

        return new class($flash) implements \ArrayAccess {

            /**
             * @var array
             */
            private $old;

            /**
             *  constructor.
             * @param ZendFlashMessages $flash
             */
            public function __construct(ZendFlashMessages $flash)
            {
                $this->old = $flash->getFlash('old', []);
            }

            /**
             * @param string|int $offset
             * @return bool
             */
            public function offsetExists($offset)
            {
                return array_key_exists($offset, $this->old);
            }

            /**
             * @param string|int $offset
             * @return mixed|null
             */
            public function offsetGet($offset)
            {
                if (! $this->offsetExists($offset)) {
                    return null;
                }

                return $this->old[$offset];
            }

            /**
             * @param string|int $offset
             * @param mixed $value
             */
            public function offsetSet($offset, $value)
            {
                $this->old[$offset] = $value;
            }

            /**
             * @param string|int $offset
             */
            public function offsetUnset($offset)
            {
                if ($this->offsetExists($offset)) {
                    unset($this->old[$offset]);
                }
            }

            /**
             * @param $name
             * @return mixed|null
             */
            public function __get($name)
            {
                return $this->offsetGet($name);
            }

            /**
             * @param $name
             * @param $arguments
             * @return mixed|null
             */
            public function __call($name, $arguments)
            {
                return $this->offsetGet($name);
            }
        };
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        if (is_null($this->flash->getFlash($offset))) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->flash->getFlash($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->flash->flash($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        return;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func([$this, $name], $arguments);
        }

        return $this->offsetGet($name);
    }
}
