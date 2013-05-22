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
	private $loginInfo = array(
		'loggedIn' => false,
	);

	public function getLoginInfo()
	{
		return $this->loginInfo;
	}

	public function login($name)
	{
		$this->loginInfo['loggedIn'] = true;
		$this->loginInfo['name'] = $name;
		$this->loginInfo['date'] = new DateTime();
		return $this->loginInfo;
	}
}
