<?php
namespace User\Model;

use Zend\Crypt\Password\PasswordInterface;

interface PasswordAwareInterface
{
    /**
     * Sets the password adapter
     * @param PasswordInterface $adapter
     */
    public function setPasswordAdapter(PasswordInterface $adapter);

    /**
     * Gets the password adapter
     * @return PasswordInterface
     */
    public function getPasswordAdapter();

}
