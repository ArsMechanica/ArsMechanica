<?php
namespace ArsMechanica\DataBase;

class MysqlLink {
	
private static $Instance;

private function __construct() {}

public static function getLink() {
	if(empty(self::$Instance)) {
		self::$Instance = new \mysqli(DB_PATH, DB_USER, DB_PASSWORD, DB_SCEME);
		if(self::$Instance -> connect_errno > 0) {
			throw new \Exception('MySQL connect error/Ошибка Подключения к базе данных "'.self::$Instance->connect_error.'"('.self::$Instance->connect_errno.').');
			}
		self::$Instance->set_charset("utf8");
        self::$Instance->autocommit(false);
		}
	return self::$Instance;
	}
	/**/
}