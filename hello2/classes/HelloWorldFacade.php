<?php
/**
 * Part of examples for Dabros version 0.1.0
 *
 * @author  Dmitry Bystrov <uncle.demian@gmail.com>, 2013
 * @source  https://github.com/dab-libs/dabros
 * @date    2013-03-08
 * @license Lesser GPL licenses (http://www.gnu.org/copyleft/lesser.html)
 */

/**
 * Пример простешего фасадного класс
 */
class HelloWorldFacade
{

	public function getMyUser()
	{
		return dabros::getUserSession()->getUser();
	}

	public function register($login, $password)
	{
		$user = dabros::getRemoteObjectManager()->createObject('HelloUser', 'user_' . $login, array($login, $password));
		if (!is_null($user))
		{
			$user->_addRole('user');
			dabros::getUserSession()->login($user);
			return $user;
		}
		return null;
	}

	public function login($login, $password)
	{
		$user = dabros::getRemoteObjectManager()->getObjectProxy('user_' . $login);
		/* @var $user User */
		if (!is_null($user) && $user->_isPassword($password))
		{
			dabros::getUserSession()->login($user);
			return $user;
		}
		return null;
	}

	public function logout()
	{
		dabros::getUserSession()->logout();
		return $this->getMyUser();
	}

	public function _accessRules()
	{
		return array(
			array(
				'deny',
				'roles' => array('user'),
				'methods' => array('login'),
			)
		);
	}

}
