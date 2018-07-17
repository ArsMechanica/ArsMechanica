<?php
namespace ArsMechanica\User;

use ArsMechanica\DomainModel\Key;
use ArsMechanica\DateTime\DateTime;

class User 
extends \ArsMechanica\DomainModel\DomainObject 
{
    protected $userNick				= 'Абстрактец';
	protected $userSurname			= 'Абстрактов';
	protected $userName 			= 'Абстракт';
	protected $userPatronymic		= 'Абстрактович';
	protected $UserBirthDay;
	protected $UserContactList;


	protected function __construct() {
		parent::__construct();
		$this->Key					= new Key(['projectId' => -1, 'objId' => NULL]);
		$this->typeId				= -1;
		$this->type 				= "User";
		$this->name					= 'Абстрактный пользователь';

		//$this -> user_contact_list_obj	= new \User\UserContactList();
		}

public static function CreateFullForm():User {
	$User = new User();
	$User->UserBirthDay	= new DateTime();
	return $User;
	}
	
public static function CreateShortForm():User {
	return new User();
	}

	
public function setUserNick(string $userNick) {
	$this->userNick = mb_convert_encoding($userNick, 'UTF-8', 'auto');
	}

public function getUserNick():string {
	return $this->userNick;
	}
	
public function setUserName(string $userName) {
	$this->userName = mb_convert_encoding($userName, 'UTF-8', 'auto');
	}

public function getUserName():string {
	return $this->userName;
	}

public function setUserSurname(string $userSurname) {
	$this->userSurname = mb_convert_encoding($userSurname, 'UTF-8', 'auto');
	}

public function getUserSurname():string {
	return $this->userSurname;
	}
	
public function setUserPatronymic(string $userPatronymic) {
	$this->userPatronymic = mb_convert_encoding($userPatronymic, 'UTF-8', 'auto');
	}

public function getUserPatronymic():string {
	return $this->userPatronymic;
	}
	
public function getInitials():string {
	return mb_substr($this->userName, 0, 1) . '. ' . mb_substr($this->userPatronymic, 0, 1) . '.';
	}
	
public function getBirthDay():DateTime {
	return $this->UserBirthDay;
	}


public function toStdClass():\stdClass {
	$stdObj = parent::toStdClass();
	$stdObj ->surname		= $this->user_surname_str;
	$stdObj ->name			= $this->user_name_str;
	$stdObj ->patronymic	= $this->user_patronymic_str;
	$stdObj ->contact_list	= $this->user_contact_list_ob->toStdClass();
	return $stdObj;
	}
/* */
}