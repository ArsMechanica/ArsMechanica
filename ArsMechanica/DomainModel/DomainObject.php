<?php
namespace ArsMechanica\DomainModel;

use PDO;
use ArsMechanica\DataBase\PDOLink;
use ArsMechanica\User\User;
use ArsMechanica\MicroFormats\DateTime;

class DomainObject 
extends AbstractObject 
{
	protected $Key;
	protected $statusId			= 1;
	protected $status	    	= 'visible';
	protected $name				= 'Новый базовый объект домена';
	protected $typeId			= 1;
	protected $type		    	= 'DomainObject';
	protected $subtypeId		= NULL;
	protected $subtype  		= NULL;
	protected $CreateUser;
	protected $CreateDateTime;
	protected $EditUser;
	protected $EditDateTime;
	
	
	protected function __construct()
    {
		$this->Key = new Key();
	}

	public static function CreateFullForm():DomainObject
    {
		$NewDomainObject = new DomainObject();
		$NewDomainObject->CreateUser = User::CreateShortForm();
		$NewDomainObject->CreateDateTime = new DateTime();
		$NewDomainObject->EditUser = User::CreateShortForm();
		$NewDomainObject->EditDateTime = new DateTime();
		return $NewDomainObject;
	}
	
	public static function CreateShortForm():DomainObject
    {
		$NewDomainObject = new DomainObject();
		return $NewDomainObject;
	}

	final public function setKey(Key $Key):void
    {
		$this->Key = $Key;
    }
	
	final public function getKey():Key
    {
		return $this->Key;
    }

	public function setStatusId(int $statusId):void
    {
		$PDOLink = PDOLink::getInstance();
		
		$statusCheckStmt = $PDOLink->prepare('SELECT 
			`obj_status` 
			FROM `object_status_list` 
			WHERE `obj_status_id` = :status_id');
		$statusCheckStmt->bindValue(':status_id', $statusId, PDO::PARAM_INT);
		$statusCheckStmt->execute();

		$statusCheck = $statusCheckStmt->fetch(PDO::FETCH_OBJ);

		if(!$statusCheck) {
			throw new \Exception('Unknown object status ID(' . $statusId . ')');
		}

		$this->statusId = $statusId;
		$this->statusName = $statusCheck->obj_status;
	}
	
	public function loadStatus(int $statusId, string $statusName):void
    {
		$this->statusId = $statusId;
		$this->statusName = $statusName;
	}
	
	public function getStatusId():int
    {
		return $this->status_id;
    }
	
	public function getStatus():string
    {
		return $this->statusName;
    }

	public function setName($name):void
    {
		$name = (string)$name;
		$name = mb_convert_encoding($name, 'UTF-8', 'auto');
		$this->name = $name;
    }
	
	public function getName():string
    {
		return $this->name;
    }
	
	public function	setTypeId(int $typeId):void {
        $PDOLink = PDOLink::getInstance();
		$typeRes = $PDOLink->query('SELECT `type_name` FROM `object_types` WHERE `type_id` = ' . $typeId);
		if($typeRes -> num_rows < 1) {
			throw new \Exception('Type not found/Тип не найден');
        }
			
		$this -> typeId = $typeId;
		$this -> typeName = $typeRes->fetch_object()->type_name;
		}
	
	public function loadType(int $typeId, string $typeName)
    {
		$this->typeId = $typeId;
		$this->typeName = $typeName;
    }

	public function	getTypeId():int
    {
		return $this -> typeId;
    }

	public function	getTypeName():string
    {
		return $this -> typeName;
    }
	
	public function	getSubTypeId():int
    {
		return $this -> subtypeId;
    }

	final public function getCreateUser():User
    {
		if(empty($this->CreateUser)) {
			$this->CreateUser = User::CreateShortForm();
        }
		return $this->CreateUser;
    }

	final public function getEditUser():\ArsMechanica\User\User
    {
		if(empty($this->EditUser)) {
			$this->EditUser = User::CreateShortForm();
        }
		return $this->EditUser;
    }
		
	final public function getCreateDate():\ArsMechanica\DateTime\DateTime
    {
		if(empty($this->CreateDateTime)) {
			$this->CreateDateTime = new \ArsMechanica\DateTime\DateTime();
        }
		return $this->CreateDateTime;
    }

	public function getEditDate():\ArsMechanica\DateTime\DateTime
    {
		if(empty($this->EditDateTime)) {
			$this->EditDateTime = new \ArsMechanica\DateTime\DateTime();
        }
		return $this->CreateDateTime;
    }

	public function toStdClass():\stdClass
    {
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
}