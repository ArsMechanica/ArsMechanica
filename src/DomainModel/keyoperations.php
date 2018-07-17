<?php
namespace DomainModel;

use ArsMechanica\DomainModel\Key;
use PDO;
use ArsMechanica\DataBase\PDOLink;

abstract class KeyOperations {

	public static function generateNewKey(Key $Key):void {
		$PDOLink = PDOLink::getInstance();

		$keyCheckStmt = $PDOLink->prepare('CALL `GenerateIdNextId`(:project_id)');

		$keyCheckStmt->bindValue(':project_id', $Key->getProjectId(), PDO::PARAM_INT);
		$keyCheckStmt->execute();

		if(!$keyCheck = $keyCheckStmt->fetch(PDO::FETCH_OBJ)) {
			throw new \Exception('Project not found in KeyGeneration or DataBase errror');
		}

		
		if($keyCheckStmt->errorCode() > 0) {
			throw new \Exception('PDO error"' . $keyCheckStmt->errorInfo() . '" in KeyGeneration');
			}
		
		$Key->setId($keyCheck->next_id);
		}

	public function equalsKey(\DomainModel\Key $FirstKey, \DomainModel\Key $SecondKey) {
		if($FirstKey->getProjectId() == $SecondKey->getProjectId() && $FirstKey->getId() == $SecondKey->getId()) {
			return TRUE;
			}
		return FALSE;
		}
	}