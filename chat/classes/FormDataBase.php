<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormDataBase
 *
 * @author Dmitry Bystrov <uncle.demian@gmail.com>
 */
class FormDataBase
{
	private $errors = array();

	public function validate($formData)
	{
		return !$this->hasErrors();
	}

	public function addError($field, $message)
	{
		$this->errors[$field] = $message;
	}

	public function getError($field)
	{
		return $this->errors[$field];
	}

	public function getErrorFields()
	{
		return array_keys($this->errors);
	}

	public function hasErrors()
	{
		return (count($this->errors) != 0);
	}

}
