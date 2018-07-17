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

		$query = 'SELECT 
            `user_id`, 
            `user_nickname`, 
            `user_surname`, 
            `user_name`, 
            `user_patronymic`, 
            `date_of_birth_ut`, 
            `user_country`, 
            `user_city`, 
            `emergency_tel`, 
            `emergency_person`, 
            `disease`, 
            `user_current_block_id`, 
            `obj_status_id`, 
            `obj_status`,
            `obj_name`, 
            `create_user_id`, 
            `create_timestamp`, 
            `edit_user_id`, 
            `edit_timestamp`
            FROM `users_list` 
            JOIN `objects_list` ON `user_id` = `obj_id` AND `project_id` = -1
            JOIN `obj_status_list` USING(`obj_status_id`) 
            WHERE `user_id` = ?';

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
		$User->setUserNick($LoadedObject->user_nickname);
		$User->setUserName($LoadedObject->user_name);
		$User->setUserSurname($LoadedObject->user_surname);
		$User->setUserPatronymic($LoadedObject->user_patronymic);
		$User->getBirthDay()->setTimestamp($LoadedObject->date_of_birth_ut);
		$User->loadStaus($LoadedObject->obj_status_id, $LoadedObject->obj_status);
		$User->getCreateDate()->setTimestamp($LoadedObject->create_timestamp);
		return $User;
		}

	protected function doInsert(User $User):void {

		}

	}