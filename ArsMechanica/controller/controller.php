<?php
namespace Controller;
class Controller {
	private $applicationHelper;

	private function __construct(){}

	static function run() {
		$instance = new Controller();
		$instance->init();
		$instance->handleRequest();
		echo 'Run sucses';
		}

	function init() {
		$this->applicationHelper = ApplicationHelper::getInstance();
		$this->applicationHelper->init();
		}
	
	function handleRequest($Request) {
		
		if(!empty($Request)) {
			if(!($Request instanceof \Controller\Request)) {
				throw new \Exception('Method handleRequest must get only Reques parametr');
				}
			$Request = new \Controller\Request();
			}
		//$cmd_r = new \Command\CommandResolver();
		$cmd = $cmd_r->getCommand($Request);
		$cmd->execute($Request);
		/* */
		}
	/* */
	}