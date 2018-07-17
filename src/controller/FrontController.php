<?php
namespace ArsMechanica\Controller;

use \ArsMechanica\Command\CommandResolver;
use \ArsMechanica\Controller\Request;

class FrontController
{
    use \ArsMechanica\Interfaces\Singleton;

	private $ApplicationHelper;

	private function __construct(){}

	static function run()
    {
		$Instance = self::getInstance();
		$Instance->init();
		$Instance->handleRequest();
    }

	function init()
    {
		$this->ApplicationHelper = ApplicationHelper::getInstance();
		$this->ApplicationHelper->init();
    }
	
	function handleRequest()
    {
        $Request = Request::getInstance();

		$CommandResolver = new CommandResolver();
		$Command = $CommandResolver->getCommand($Request);
		$Command->execute($Request);
    }
}