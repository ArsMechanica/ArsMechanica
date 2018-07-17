<?php
namespace ArsMechanica\DataMapper;

use ArsMechanica\DomainModel\Key;
use ArsMechanica\DomainModel\DomainObject;

abstract class AbstractDataMapper {
	use \ArsMechanica\Interfaces\Singleton;

	public abstract function LoadByKey(Key $Key);

	final public function insert($Object):void {
		$this->doInsert($Object);
		}

	protected abstract function doInsert(DomainObject $Object);
		
	/*
	public abstract function LazyLoadById(\ArsMecanika\DomainModel\Key $Key);
		
	function createObject($array) {
		$object = $this -> doCreateObject($array);
		return $object;
		}
	
	function insert(\DomainModel\BaseObject $Object) {
		return $this->doInsert($Object);
		}
		
	abstract function update(\DomainModel\BaseModel $Object);
	protected abstract function doCreateObjectFromArr(array $array);
	protected abstract function doCreateObjectFromStdClass(\stdClass $object);
	protected abstract function doInsert(\DomainModel\BaseObject $Object);
	//protected abstract function selectStmt();
	*/
	}