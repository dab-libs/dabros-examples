<?php
/**
 * Part of examples for Dabros version 0.1.0
 *
 * @author  Dmitry Bystrov <uncle.demian@gmail.com>, 2013
 * @source  https://github.com/dab-libs/dabros
 * @date    2013-05-26
 * @license Lesser GPL licenses (http://www.gnu.org/copyleft/lesser.html)
 */

/**
 * Пользователь приложения HelloWorld
 */
class HelloUser extends RemoteUser
{

  /**
   * Дата создания (регистрации) учетной записи пользователя
   * @var DateTime
   */
  private $createdDate;

  /**
   * Создает объект
   */
  public function __construct($login, $password)
  {
    parent::__construct($login, $password);
    $this->createdDate = new DateTime();
  }

  /**
   * Возвращает дату создания (регистрации) учетной записи пользователя
   * @return DataTime
   */
  public function getCreatedDate()
  {
    return $this->createdDate;
  }

  public function _consts()
  {
    return array_merge(parent::_consts(), array(
      'getCreatedDate'
    ));
  }

}
