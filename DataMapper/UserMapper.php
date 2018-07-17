<?php
namespace DataMapper;

use ArsMechanica\DataBase\MysqlLink;

class UserMapper extends AbstractDataMapper {
	
	
	function getCollection(array $raw_arr) {
		return new \DataMapper\UserCollection($raw_arr, $this);
	}

	public function findById($id) {
		$BdLink = MysqlLink::getLink();
		
		$query = 'SELECT * FROM `list_object_pr'.PROJECT_ID.'` WHERE `id` = '.$id;
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


	public function doInsert(\DomainModel\BaseModel $BaseModel) {
		$BdLink = MysqlLink::getLink();
		$CurrentUser = \ArsMechanica\User\CurrentUser::getInstance();
		
		$query = 'INSERT INTO `list_object_pr'.PROJECT_ID.'` SET';
		$query .= ' `view`='.$BaseModel->getView().',';
		$query .= ' `name`="'.htmlentities($BaseModel->getName(), ENT_QUOTES, 'utf-8').'",';
		$query .= ' `type_id`='.$BaseModel->getTypeId().',';
		if(!is_null($BaseModel -> getSubTypeId())) {
			$query .= '`subtype_id`='.$BaseModel->getSubTypeId().',';
			}
		$query .= ' `create_user_id`='.$CurrentUser->getId().',';
		$query .= ' `create_time`=NOW()';
		echo($query);
		
		$BdLink->query($query);
		if($BdLink -> errno > 0) {
			throw new \Exception('Database Error "'.$BdLink->error.'" (№'.$BdLink->errno.')');
			}
		$id = $BdLink -> insert_id;
		var_dump($id);
		$BaseModel->setId($BdLink -> insert_id);
		
		return $BaseModel;
		}

	public function update(\DomainModel\BaseModel $BaseModel) {
		
		}
		
	protected function doCreateObjectFromArr(array $array) {
		$CreatedObject = new \DomainModel\BaseModel();
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