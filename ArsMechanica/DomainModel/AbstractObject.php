<?php
namespace ArsMechanica\DomainModel;

abstract class AbstractObject {
    use \ArsMechanica\Interfaces\toJSONable;

	abstract public static function CreateFullForm();
	abstract public static function CreateShortForm();

    //Magic Methods
	function __get($propertyName) {
		throw new \Exception('It is forbidden to get undefined property in AbstractObject Class.');
		}
		
	function __set($propertyName, $value) {
		throw new \Exception('It is forbidden to set undefined property in AbstractObject Class.');
		}
		
	function __isset($propertyName) {
		throw new \Exception('It is forbidden to check undefined property in AbstractObject Class.');
		}
		
	function __unset($propertyName) {
		throw new \Exception('It is forbidden to unset property in AbstractObject Class.');
		}
		
	function __call($methodName, $arguments) {
		throw new \Exception('It is forbidden to call undefined method in AbstractObject Class.');
		}
		
	public static function __callStatic($methodName, $arguments) {
		throw new \Exception('It is forbidden to call undefined static method in AbstractObject Class.');
		}
	}