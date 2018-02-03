<?php
declare(strict_types=1);


namespace Core\Lib\Flash;

interface FlashMessagesInterface extends \ArrayAccess
{
    /**
     * @return bool
     */
    public function hasErrors() : bool;

    /**
     * @return array
     */
    public function getErrors() : array;

    /**
     * @param string $field
     * @return bool
     */
    public function hasError(string $field) : bool;

    /**
     * @param string $field
     * @param bool $singleMessage
     * @return string|array
     */
    public function getError(string $field, bool $singleMessage = true);

    /**
     * @return \ArrayAccess
     */
    public function old() : \ArrayAccess;
}
