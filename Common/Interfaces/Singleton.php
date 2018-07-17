<?php
declare(strict_types=1);

namespace ArsMechanica\Interfaces;

trait Singleton
{
	static protected $Instance;

	private function __construct() {}

	private function __clone() {}

	private function __wakeup() {}

	public static function getInstance()
    {
		if (empty(static::$Instance)) {
			static::$Instance = new static();
        }
		return static::$Instance;
    }
}