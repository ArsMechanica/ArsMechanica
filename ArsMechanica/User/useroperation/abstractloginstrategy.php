<?php
namespace \User\Useroperation
abstract class LoginAbstractStrategy {
	protected $CurrentUser;

	function __construct(\User\CurrentUser $CurrentUser) {
		$this->CurrentUser = $CurrentUser;
		}
	}

	abstract function login($login_context);
}