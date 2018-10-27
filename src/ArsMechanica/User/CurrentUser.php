<?php
/**
 * Decorator Pattern (for ArsMechanica\User\User)
 * Singleton Pattern
 */

namespace ArsMechanica\User;

use ArsMechanica\DataMapper\UserDataMapper;
use ArsMechanica\Registry\SessionRegistry;


class CurrentUser
{
    use \ArsMechanica\Interfaces\Singleton;

    private $User;

    private function __construct(?User $User)
    {
        $this->User = $User;
    }


    public static function getInstance()
    {
        $SessionRegistry = SessionRegistry::getInstance();

        if (empty(self::$Instance)) {
            if ($SessionRegistry->get('user_id') > 0) {
                self::$Instance = new CurrentUser(UserDataMapper::LoadById($SessionRegistry->get('user_id')));
            } elseif (isset($_COOKIE['remember-me']) AND $_COOKIE['remember-me'] == 1) {
                //Проверяем куки
            } else {
                self::$Instance = new CurrentUser(AnonymousUser::CreateFullForm());
            }
        }
        return self::$Instance;
    }

    public static function reload()
    {
        self::$Instance = null;
        return self::getInstance();
    }


    public function __call($name, $arguments)
    {
        $methodVariable = [$this->User, $name];
        if (!is_callable($methodVariable, true, $callable_name)) {
            throw new \Exception('It is forbidden to refer to non-existent methods in the class CurrentUser/User');
        }
        return $this->User->$name($arguments);
    }


    public function isAnonymous(): bool
    {
        #TODO
        return !isset($_SESSION['user_id']);
        //return ($this->User instanceof AnonymousUser);
    }

    public function checkRight(array $rights) {
        switch (true) {
            case (in_array('admin', $rights) AND isset($_SESSION['user_id']) AND $_SESSION['user_id'] <0):
                return true;
                break;

            default:
                return false;
                break;
        }
    }


    public function setKey(\DomainModel\Key $Key)
    {
        throw new \Exception('Нельзя менять ИД текущего юзера');
    }
}