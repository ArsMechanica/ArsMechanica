<?php
namespace ArsMechanica\User;

use \ArsMechanica\DomainModel\DomainObject;
use \ArsMechanica\DomainModel\Key;
use \ArsMechanica\MicroFormats\DateTime;

class User
    extends DomainObject
{
    protected $userNick         = 'Абстрактец';
    protected $userSurname      = 'Абстрактов';
    protected $userName         = 'Абстракт';
    protected $userPatronymic   = 'Абстрактович';
    protected $userType         = 'Абстрактный пользователь';
    protected $UserBirthDay;
    protected $UserContactList;


    public function __construct()
    {
        $this->Key = new Key(['projectId' => -1, 'objId' => null]);
        $this->typeId = -1;
        $this->type = "User";
        $this->subtypeId = 1;
        $this->subtype = 'Абстрактный пользователь';
        $this->name = 'Абстрактный пользователь';
        $this->UserContactList	= new UserContactList();
    }

    public static function CreateFullForm():DomainObject
    {
        $User = new User();
        $User->UserBirthDay = new DateTime();
        return $User;
    }

    public static function CreateShortForm():DomainObject
    {
        return new User();
    }


    public function setUserNick(string $userNick):void
    {
        $this->userNick = mb_convert_encoding($userNick, 'UTF-8', 'auto');
    }

    public function getUserNick():string
    {
        return $this->userNick;
    }

    public function setUserName(string $userName):void
    {
        $this->userName = mb_convert_encoding($userName, 'UTF-8', 'auto');
    }

    public function getUserName():string
    {
        return $this->userName;
    }

    public function setUserSurname(string $userSurname):void
    {
        $this->userSurname = mb_convert_encoding($userSurname, 'UTF-8', 'auto');
    }

    public function getUserSurname():string
    {
        return $this->userSurname;
    }

    public function setUserPatronymic(string $userPatronymic):void
    {
        $this->userPatronymic = mb_convert_encoding($userPatronymic, 'UTF-8', 'auto');
    }

    public function getUserPatronymic():string
    {
        return $this->userPatronymic;
    }

    public function setUserType(string $userType):void
    {
        $this->userType = mb_convert_encoding($userType, 'UTF-8', 'auto');
    }

    public function getUserType():string
    {
        return $this->userType;
    }

    public function getInitials():string
    {
        return mb_substr($this->userName, 0, 1) . '. ' . mb_substr($this->userPatronymic, 0, 1) . '.';
    }

    public function getBirthDay():DateTime
    {
        return $this->UserBirthDay;
    }

    public function getContactList():UserContactList
    {
        return $this->UserContactList;
    }


    public function toStdClass():\stdClass
    {
        $stdObj = parent::toStdClass();
        $stdObj->surname = $this->getUserSurname();
        $stdObj->name = $this->getUserName();
        $stdObj->patronymic = $this->getUserPatronymic();
        $stdObj->contact_list = $this->getContactList()->toStdClass();
        return $stdObj;
    }
}