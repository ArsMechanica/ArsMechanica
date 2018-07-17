<?php
namespace ArsMechanica\DataBase;

use PDO;

class PDOLink
extends AbstractDataBase {

	private $dns;

	private function __construct() {}

	public static function getInstance() {
		if(empty(self::$Instance)) {
			try {
				$dns = 'mysql:dbname=' . DB_SCEME . ';host=' . DB_PATH . ';charset=UTF8';
				self::$Instance = new PDO($dns, DB_USER, DB_PASSWORD);

				self::$Instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				self::$Instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
			catch (PDOException $e) {
				throw $e;
				}
			}
		return self::$Instance;
		}
	/**/
	}