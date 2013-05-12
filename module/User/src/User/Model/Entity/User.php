<?php
namespace User\Model\Entity;

class User {
	protected $id;
	protected $role;
	protected $name;
	protected $email;
	protected $phone;
	protected $photo;

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
		$this->photo = $photo;
	}

}
