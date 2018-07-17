<?php
namespace ArsMechanica\User;

use ArsMechanica\DomainModel\DomainObject;

class AnonymousUser
extends User
{
	public function __construct()
	{
		parent::__construct();
        $this->getKey()->setId(-1);
		$this->subtypeId			= 2;
		$this->type				    = "Анонимный пользователь";

		$this->name					= 'Неавторизированный пользователь';
		$this->userNick				= 'Anonymous';
		$this->userSurname			= 'Анонимов';
		$this->userName 			= 'Аноним';
		$this->userPatronymic		= 'Анонимович';
	}

	public static function CreateShortForm():DomainObject
    {
		$AnonymousUser = new AnonymousUser();
		return $AnonymousUser;
	}

	public static function CreateFullForm():DomainObject
    {
		$AnonymousUser = new AnonymousUser();
		return $AnonymousUser;
	}
}