<?php
namespace User;
class UserContactList 
extends \DomainModel\BaseModel {

protected $user_id					= -1;
protected $contact_list_arr			= array();

	
public function __construct() {
	}
	


public function toStdClass() {
	$stdObj = new \stdClass;
	return $stdObj;
	}
}