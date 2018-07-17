<?php
namespace ArsMechanica\Command;

use ArsMechanica\Controller\Request;

class CommandResolver {
	private static $baseCommand;
	private static $defaultCommand;
	
	public function __construct() {
		if(!self::$baseCommand) {
			self::$baseCommand = new \ReflectionClass('\ArsMechanica\\Command\\Command');
			self::$defaultCommand = new DefaultCommand();
		    }
	    }
	
	public function getCommand(Request $Request) {
		$cmd = $Request->getCommand();
		if(!$cmd) {
			return self::$defaultCommand;
			}

		$className = '\Command\\' . $cmd;
		if(class_exists($className)) {
			$Command = new $className();

            print_r($Command);

			if($Command->isSubclassOf(self::$baseCommand)) {
				return $Command->newInstance();
				}
			else {
				$Request->addError('Command Object "' . $cmd . '" not found');
				}
			}
		$Request->addWarning('Command "' . $cmd . '" not found');
		return clone self::defaultCommand;
	    }
    }