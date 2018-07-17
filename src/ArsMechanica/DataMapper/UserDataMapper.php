<?php
declare(strict_types=1);
namespace ArsMechanica\DataMapper;

use ArsMechanica\DomainModel\Key;
use ArsMechanica\User\User;
use ArsMechanica\DataBase\MysqlLink;

class UserDataMapper extends AbstractDomainMapper {
	public function LoadByKey(Key $Key) {
		
		}
		
	public static function LoadById(int $id): ?User {
		$BdLink = MysqlLink::getLink();

		$query = 'SELECT * FROM `users` WHERE `user_id`= ?';

        $stmt = $BdLink->stmt_init();
        if(!$stmt->prepare($query)) {
            throw new \Exception('Ошибка подготовки запроса');
            }

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $LoadedObjectRes = $stmt->get_result();
        
		if($LoadedObjectRes->num_rows == 0) {
			return NULL;
			}
		$LoadedObject = $LoadedObjectRes->fetch_object();

		$User = User::CreateFullForm();
		$User->getKey()->setId($id);
		$User->setUserName($LoadedObject->user_name);
		$User->setUserType($LoadedObject->user_type);

		return $User;
		}

	protected function doInsert($Object):void {

		}

	}