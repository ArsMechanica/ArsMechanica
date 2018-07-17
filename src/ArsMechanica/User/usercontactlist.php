<?php
namespace ArsMechanica\User;

class UserContactList
{
    protected $userId					= -1;
    protected $contact_list_arr			= array();

	
    public function __construct()
    {
	}
	


    public function toStdClass()
    {
        $stdObj = new \stdClass;
        return $stdObj;
	}
}