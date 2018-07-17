<?php
namespace \User\Useroperation
class LoginVk extends LoginAbstractStrategy {

function __construct(\User\CurrentUser $CurrentUser) {
	parent::__construct($CurrentUser);
	}
	
}
}