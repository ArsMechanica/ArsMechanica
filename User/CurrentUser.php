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
    private $accessRights = [];

    protected function __construct(?User $User)
    {
        $this->User = $User;
        $this->loadRights();
    }

    public static function getInstance($newInstance = false)
    {
        $SessionRegistry = SessionRegistry::getInstance();

        if (empty(self::$Instance)) {
            if (!empty($_SESSION['user_id'])) {
                self::$Instance = new CurrentUser(UserDataMapper::LoadById($SessionRegistry->get('user_id')));
            } elseif ($_COOKIE['remember-me'] == 1) {
                //Проверяем куки
            } elseif ($newInstance === true) {
                //Ветка для анонимных юзеров
            } else {
                self::$Instance = new CurrentUser(AnonymUser::CreateFullForm());
            }
        }
        /* */
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

    public function setKey(\DomainModel\Key $Key)
    {
        throw new \Exception('Нельзя менять ИД текущего юзера');
    }

    public function isAnonymous():bool {
        return ($this->User instanceof AnonymousUser);
    }

    protected function loadRights() {

    }

    public function checkRights(array $neededRight):bool {
        return(count(array_intersect($neededRight, $this->accessRights)) >0);
    }

    public function clearRights():void {
        $this->accessRights = [];
    }

}