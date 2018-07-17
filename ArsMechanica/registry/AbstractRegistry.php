<?php
namespace ArsMechanica\Registry;

abstract class AbstractRegistry {
	abstract public function get($key);
	abstract public function isSet($key):bool;
	abstract public function set($key, $value):void;
	abstract public function unset($key):void;
	}