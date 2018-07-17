<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 07.12.2016
 * Time: 12:55
 */

namespace ArsMechanica\User;



class AnonymUser
extends User
{
	protected function __construct()
	{
		parent::__construct();
		$this->subtypeId			= 2;
		$this->typeName				= "Анонимный пользователь";

		$this->name					= 'Неавторизированный пользователь';
		$this->userNick				= 'Anonim';
		$this->userSurname			= 'Анонимов';
		$this->userName 			= 'Аноним';
		$this->userPatronymic		= 'Анонимович';
	}

	public static function CreateShortForm() {
		$AnonymUser = new AnonymUser();
		return $AnonymUser;
	}

	public static function CreateFullForm() {
		$AnonymUser = new AnonymUser();
		return $AnonymUser;
	}
}