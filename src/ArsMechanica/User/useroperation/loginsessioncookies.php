<?php
namespace \User\Useroperation
class LoginSessionCookies extends LoginAbstractStrategy {

function __construct(\User\CurrentUser $CurrentUser) {
	parent::__construct($CurrentUser);
	}
	
function login() {
	if($_COOKIE['user_id'] > 0) {
		$CurrentUser = \DataMapper\Usermapper::findById($_COOKIE['user_id']);
		}
	elseif($_SESSION['user_id'] > 0) {
		$CurrentUser = \DataMapper\Usermapper::findById($_SESSION['user_id']);
		}
	return $CurrentUser;
	}
}
