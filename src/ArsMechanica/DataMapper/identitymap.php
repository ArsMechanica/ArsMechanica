<?php
namespace DataMapper;
class IdentityMap {
	private $all_arr = array();
	private static $instance_obj;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(empty(self::$instance_obj)) {
			self::$instance_obj = new \DataMapper\IdentityMap();
			}
		return self::$instance_obj;
		}

	public static function globalKey(\DomainModel\BaseModel\ $obj) {
		return $obj->getProjectId() . '-' . $obj->getId();
		}
		
	static function addObj(\DomainModel\BaseModel\ $Obj) {
		$IdentityMap = self::getInstance();
		$IdentityMap->$all_arr[$IdentityMap->globalKey($Obj)] = $Obj;
		}
		
	static function existsObj($obj_id, $project_id) {
		$IdentityMap = self::getInstance();
		$key = $project_id . '-' . $obj_id;
		if(isset($IdentityMap->$all_arr[$key])) {
			return $IdentityMap->$all_arr[$key];
			}
		return NULL;
		}
	}