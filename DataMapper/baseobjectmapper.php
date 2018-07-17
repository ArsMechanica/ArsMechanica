<?php
namespace ArsMechanica\DataMapper;

class BaseObjectMapper extends AbstractDataMapper {
	
	
	function getCollection(array $raw_arr) {
		return new \DataMapper\BaseModelCollection($raw_arr, $this);
	}

	public abstract function LoadById(\DomainModel\Key $Key) {
		$BdLink = \DataBase\MysqlLink::getLink();
		
		$query = 'SELECT * 
			FROM `objects_list` 
			WHERE `project_id` = ' . $Key->getProjectId() . '
			AND `obj_id`=' . $Key->getId();
		$res = $BdLink->query($query);
		if($BdLink -> errno > 0) {
			throw new \Exception('Database Error "'.$BdLink->error.'" (№'.$BdLink->errno.')');
			}
		if($res -> num_rows == 0) {
			//throw new \Exception('BaseModel not found');
			return NULL;
			}
		$array = $res -> fetch_assoc();
		
		return $this -> doCreateObjectFromArr($array);
		}
		
	
	public function doInsert( \ArsMechanica\DomainModel\DomainObject $DomainObject ) {
		$BdLink = \DataBase\MysqlLink::getLink();
		$CurrentUser = \User\CurrentUser::getInstance();
		$Task = new \Controller\Task('Создание объекта в БД');
		
		try {
			if( $CurrentUser->getKey()->getId() < 1 ) {
				throw new \Exception('It is forbidden to create new object for unauthorized user');
				}
			if($BaseObject->getKey()->getId() < 1) {
				$BaseObject->setKey( \DomainModel\KeyOperations::getNewKey( $BaseObject->getKey()->getProjectId() ) );
				}
			$query = 'INSERT INTO `objects_list` SET ';
			$query .= '`project_id`=' . $BaseObject->getKey()->getProjectId() . ',';
			$query .= '`obj_id`=' . $BaseObject->getKey()->getId() . ',';
			$query .= '`obj_status_id`=' . $BaseObject->getStatusId() . ',';
			$query .= ' `obj_name`="' . htmlentities( $BaseObject->getName(), ENT_QUOTES, 'utf-8' ) . '",';
			$query .= ' `obj_type_id`=' . $BaseObject->getTypeId() . ',';
			if( !is_null( $BaseObject->getSubTypeId() ) ) {
				$query .= '`obj_subtype_id`='.$BaseObject->getSubTypeId().',';
				}
			$query .= '`create_user_id`=' . $CurrentUser->getKey()->getId() . ',';
			$query .= '`create_timestamp`=NOW()';
			echo($query);
			
			$BdLink->query($query);
			if($BdLink -> errno > 0) {
				throw new \Exception('Database Error "'.$BdLink->error.'" (№'.$BdLink->errno.') in BaseObjectMapper');
				}
			$Task->setOk('Объект успешно загружен');
			}
		catch( \Exception $e ) {
			$Task->addError( $e->getMessage );
			}
		return $Task;
		}
	
	public function update(\DomainModel\BaseModel $BaseModel) {
		NULL;
		}
		
	protected function doCreateObjectFromArr(array $array) {
		$CreatedObject = new \DomainModel\BaseObject();
		if($array['id'] > 0 && is_int($array['id'])) {
			$CreatedObject -> setId($array['id']);
			}
		$CreatedObject -> setView($array['view']);
		$CreatedObject -> setName($array['name']);
		$CreatedObject -> setTypeId($array['type_id']);
		return $CreatedObject;
		}
		
	protected function doCreateObjectFromStdClass(\stdClass $object) {
		$CreatedObject = new \DomainModel\BaseModel();
		if($object->id > 0 && is_int($object->id)) {
			$CreatedObject -> setId($object->id);
			}
		$CreatedObject -> setView($object->view);
		$CreatedObject -> setName($object->name);
		$CreatedObject -> setTypeId($object->type_id);
		return $CreatedObject;
		}
		
	protected function selectStmt() {
		return null;
		}
	/**/
	}