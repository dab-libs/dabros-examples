<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author Dmitry Bystrov <uncle.demian@gmail.com>
 */
class Auth
{
	private $userInfo;

	public function restoreSession()
	{
		return false;
	}

	public function authenticateUser($loginForm, $password)
	{
		return false;
	}

	public function registerUser($formData)
	{
		return false;
	}

}
