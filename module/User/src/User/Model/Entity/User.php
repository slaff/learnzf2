<?php
namespace User\Model\Entity;

use Zend\Form\Annotation;
use User\Model\PasswordAwareInterface;
use Zend\Crypt\Password\PasswordInterface;

/**
 * @Annotation\Name("users")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 *
 * @Entity @Table(name="users")
 */
class User implements PasswordAwareInterface
{
    /**
     * @Annotation\Exclude()
     *
     * @Id @GeneratedValue @Column(type="integer")
     */
    protected $id;

    /**
     * @Annotation\Exclude()
     *
     * @Column(type="string")
     */
    protected $role;

    /**
    * @Annotation\Type("Zend\Form\Element\Email")
    * @Annotation\Validator({"name":"EmailAddress"})
    * @Annotation\Options({"label":"Email:"})
    * @Annotation\Attributes({"type":"email","required": true,"placeholder": "Email Address..."})
    * @Annotation\Flags({"priority": "500"})
    *
    * @Column(type="string")
    */
    protected $email;

    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Password:", "priority": "400"})
     * @Annotation\Flags({"priority": "400"})
     *
     * @Column(type="string")
     */
    protected $password;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Name:"})
     * @Annotation\Attributes({"required": true,"placeholder":"Type name..."})
     * @Annotation\Flags({"priority": "300"})
     *
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Your phone number:"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"RegEx", "options": {"pattern": "/^[\d-\/]+$/"}})
     * @Annotation\Attributes({"type":"tel","required": true,"pattern": "^[\d-/]+$"})
     * @Annotation\Flags({"priority": "200"})
     *
     * @Column(type="string")
     */
    protected $phone;

    /**
     * @Annotation\Type("Zend\Form\Element\File")
     * @Annotation\Options({"label":"Your photo:"})
     * @Annotation\Attributes({"id":"photo","required": true})
     * @Annotation\Flags({"priority": "100"})
     *
     * @Column(type="string")
     */
    protected $photo;

    /**
     * @Annotation\Exclude()
     * @var PasswordInterface
     */
    protected $adapter;

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return the $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param field_type $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param field_type $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        if(isset($photo['tmp_name'])) {
            $this->photo = $photo['tmp_name'];
        }
    }

    /**
     * Gets the current password hash
     *
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $this->hashPassword($password);
    }

    /**
     * Verifies if the provided password matches the stored one.
     *
     * @param string $password clear text password
     * @return boolean
     */
    public function verifyPassword($password)
    {
        return $this->adapter->verify($password, $this->password);
    }

    /**
     * Hashes a password
     * @param string $password
     * @return string
     */
    private function hashPassword($password)
    {
        return $this->adapter->create($password);
    }

    /**
     * Sets the password adapter
     * @param PasswordInterface $adapter
     */
    public function setPasswordAdapter(PasswordInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Gets the password adapter
     * @return PasswordInterface
     */
    public function getPasswordAdapter()
    {
        return $this->adapter;
    }

}
