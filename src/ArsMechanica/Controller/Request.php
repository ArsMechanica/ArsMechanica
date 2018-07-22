<?php
namespace ArsMechanica\Controller;

use \ArsMechanica\Controller\Task;

class Request
{
    use \ArsMechanica\Interfaces\Singleton;
    use \ArsMechanica\Interfaces\toJSONable;
    use \ArsMechanica\Interfaces\ParameterAble;
    use \ArsMechanica\Interfaces\NoMagic;


    protected $command      = null;

	public function __construct()
    {
		$this->init();
		//\Registry\RequestRegistry::setRequest($this);
    }
		
	function init():void
    {
		if(isset($_SERVER['REQUEST_METHOD'])) {
		    if(array_key_exists('action', $_REQUEST)) {
                $this->command = $_REQUEST['action'];
            }

            foreach ($_REQUEST as $key=>$value) {
		        $this->addProp($key, $value);
            }
        }
        if(isset($_SERVER['argv'])) {
            foreach($_SERVER['argv'] as $arg) {
                if (strpos($arg, '=')) {
                    list($key, $val) = explode('=', $arg);
                    $this->addProp($key, $val);
                }
            }
        }
    }

	public function getCommand():?string
    {
		return $this->command;
	}


	public function toStdClass():\stdClass
    {
		$stdObj = new \stdClass();
		$stdObj->status = $this->status;
		$stdObj->header = $this->header;
		$stdObj->ok_tasks = $this->okTasks;
		$stdObj->properties = $this->properties;
		$stdObj->warnings = $this->warningTasks;
		$stdObj->errors = $this->errorTasks;
		return $stdObj;
    }
}