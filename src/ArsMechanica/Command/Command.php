<?php
namespace ArsMechanica\Command;

use ArsMechanica\Controller\Request;


abstract class Command
{
    use \ArsMechanica\Interfaces\Singleton;

	final function __construct() {}
	
	public function execute(Request $Request) {
		$this->doExecute($Request);
	}

    protected abstract function doExecute(Request $Request);
}