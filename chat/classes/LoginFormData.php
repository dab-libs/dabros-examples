<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginFormData
 *
 * @author Dmitry Bystrov <uncle.demian@gmail.com>
 */
class LoginFormData extends FormDataBase
{
	public $login;
	public $password;

	public function validate($formData)
	{
		$formData = (isset($formData) ? $formData : array());
		if (isset($formData['login']))
		{
			$this->login = $formData['login'];
		}
		else
		{
			$this->addError('login', 'Логин не указан');
		}

		if (isset($formData['password']))
		{
			$this->password = $formData['password'];
		}
		else
		{
			$this->addError('password', 'Пароль не указан');
		}

		return (!$this->hasErrors());
	}
}
