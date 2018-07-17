<?php
namespace DomainModel;

class BaseObject 
implements \Interfaces\toJSONable {
	protected $Key;
	protected $status_id		= 1;
	protected $status_str		= 'visible';
	protected $name_str			= 'Новый базовый объект';
	protected $type_id			= 1;
	protected $type_name		= 'BaseObject';
	protected $subtype_id		= NULL;
	protected $subtype_name		= NULL;
	protected $CreateUser;
	protected $CreateDateTime;
	protected $EditUser;
	protected $EditDateTime;
	
	
private function __construct() {
	$this->Key					= new \DomainModel\Key(PROJECT_ID);
	$this->CreateUser			= \User\User::create();
	$this->CreateDateTime		= new \DateTime\DateTime();
	$this->EditUser				= \User\User::create();
	$this->EditDateTime			= new \DateTime\DateTime();
	}

public static function create() {
	return new \DomainModel\BaseObject();
	}
	
public function setKey(\DomainModel\Key $Key) {
	$this->Key = $Key;
	}
	
public function getKey() {
	return $this->Key;
	}

public function setStatusId($status_id) {
	$status_id = (int)$status_id;
	$this->status_id = $status_id;
	$status_check_res = $BdLink->query('SELECT 
		`status` 
		FROM `obj_status_list` 
		WHERE `status_id` = ' . $status_id);
	if($status_check_res->num_rows != 1) {
		throw new \Exception('Unknown status_id');
		}
	$this->status_str = $status_check_res->fetch_object()->status;
	}
	
public function getStatusId() {
	return $this->status_id;
	}
	
public function getStatus() {
	return $this->status_str;
	}

public function setName($name_str) {
	$name_str = mb_convert_encoding($name_str, 'UTF-8', 'auto');
	$this -> name_str = $name_str;
	}
	
public function getName() {
	return $this -> name_str;
	}
	
public function	setTypeId($type_id) {
	$BdLink = \DataBase\MysqlLink::getLink();
	if(empty($type_id)) {
		throw new \Exception('Type_Id should not be empty/ИД типа объекта не может быть пустым');
		}
	$type_id = (int)$type_id;
	if(!is_int($type_id)) {
		throw new \Exception('Id must be Int/ИД объекта должно быть числом');
		}
	$type_res = $BdLink->query('SELECT `module_name` FROM `object_types` WHERE `type_id` = '.$type_id);
	if($type_res -> num_rows < 1) {
		throw new \Exception('Type not found/Тип не найден');
		}
	$this -> type_id = $type_id;
	$this -> type_name = $type_res->fetch_object()->module_name;
	}

public function	getTypeId() {
	return $this -> type_id;
	}

public function	getTypeName() {
	return $this -> type_name;
	}
	
public function	getSubTypeId() {
	return $this -> subtype_id;
	}

public function getCreateUser() {
	return $this->CreateUser;
	}

public function getCreateDate() {
	return $this->CreateDateTime;
	}

public function getEditUser() {
	return $this->EditUser;
	}

public function getEditDate() {
	return $this->EditDateTime;
	}
	
public function toStdClass() {
	$stdObj = new \stdClass;
	$stdObj->key			= $this->Key->toStdClass();
	$stdObj->view			= $this->view_bl;
	$stdObj->name			= $this->name_str;
	$stdObj->type_id		= $this->type_id;
	$stdObj->create_date	= $this->create_date_obj->toStdClass();
	$stdObj->create_user	= $this->create_user_obj ->toStdClass();
	$stdObj->edit_date		= $this->edit_date_obj->toStdClass();
	$stdObj->edit_user		= $this->edit_user_obj ->toStdClass();
	
	return $stdObj;
	}
	
final public function toJSON() {
	return json_encode($this->toStdClass());
	}
	
//magic methods
function __get($property_name_str) {
	throw new \Exception('It is forbidden to get undefined property in DomainModel Class/Запрещено обращаться к неотпределенным свойства в классе BaseModel');
	}
	
function __set($property_name_str, $value) {
	throw new \Exception('It is forbidden to set undefined property in DomainModel Class/Запрещено задавать  неотпределенные свойства в классе BaseModel');
	}
	
function __isset($property_name_str) {
	throw new \Exception('It is forbidden to get undefined property in DomainModel Class/Запрещено обращаться к неотпределенным свойства в классе BaseModel');
	}
	
function __unset($property_name_str) {
	throw new \Exception('It is forbidden to unset undefined property in DomainModel Class/Запрещено удалять необъявленные свойства в классе BaseModel');
	}
	
function __call($method_name_str, $arg_mix_array) {
	throw new \Exception('It is forbidden to call undefined method in DomainModel Class/Запрещено вызывать неопределенные методы в классе BaseModel');
	}
	/* */
}