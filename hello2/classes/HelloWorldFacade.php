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
 * Класс сессионного фасада приложения HelloWorld
 */
class HelloWorldFacade
{

  /**
   * Возвращает текущего пользователя
   * @return HelloUser
   */
  public function getMyUser()
  {
    return dabros::getRemoteUserSession()->getUser();
  }

  /**
   * Регистрирует нового пользователя
   * @param string $login
   * @param string $password
   * @return boolean
   */
  public function register($login, $password)
  {
    $user = dabros::getRemoteObjectManager()->createObject('HelloUser', 'user_' . $login, array($login, $password));
    if (!is_null($user))
    {
      $user->_addRole('user');
      dabros::getRemoteUserSession()->login($user);
      return true;
    }
    return false;
  }

  /**
   * Выполняет вход пользователя
   * @param string $login
   * @param string $password
   * @return boolean
   */
  public function login($login, $password)
  {
    $user = dabros::getRemoteObjectManager()->getObjectProxy('user_' . $login);
    /* @var $user RemoteUser */
    if (!is_null($user) && $user->_isPassword($password))
    {
      dabros::getRemoteUserSession()->login($user);
      return true;
    }
    return false;
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
