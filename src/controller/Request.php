<?php
namespace ArsMechanica\Controller;

use \ArsMechanica\Controller\Task;

class Request
{
    use \ArsMechanica\Interfaces\Singleton;
    use \ArsMechanica\Common\Parametrable;
    use \ArsMechanica\Interfaces\toJSONable;


	protected $status		= 'started';		//'Ok', 'warning', 'error'
    protected $command      = null;
	protected $properties	= [];
	protected $okTasks 		= [];
	protected $warningTasks = [];
	protected $errorTasks 	= [];
	


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
			$this->properties = $_REQUEST;
        }
		foreach($_SERVER['argv'] as $arg) {
			if(strpos($arg, '=')) {
				list($key, $val) = explode('=', $arg);
				$this->addProp($key, $val);
            }
        }
    }
		
	public function getCommand():?string
    {
		return $this->command;
	}

    public function setStatus($status):void
    {
        switch ($status) {
            case 'Ok':
                if($this->status === 'started') {
                    $this->status = 'Ok';
                }
                break;

            case 'warning':
                if($this->status === 'error') {
                    $this->status = 'warning';
                }
                break;

            case 'error':
                $this->status = 'error';
                break;

            default:
                throw new \Exception('Wrong Request status.');
                break;
        }
    }
	
	public function getStatus():string
    {
		return $this->status;
	}

	public function addProp($key, $value):void
    {
		$this->properties[$key] = $value;
	}

	public function getProp($key)
    {
		return $this->properties[$key];
	}

	public function getProps()
    {
		return $this->properties;
	}

    public function addOk($okText):void
    {
        array_push($this->okTasks, $okText);
    }

    public function getOkTasks():array
    {
        return $this->okTasks;
    }

    public function addWarning($warningText):void
    {
        array_push($this->warningTasks, $warningText);
        $this->setStatus('warning');
    }

    public function getWarningTasks():array
    {
        return $this->warningTasks;
    }

    public function addError($errorText):void
    {
        array_push($this->errorTasks, $errorText);
        $this->setStatus('error');
    }

    public function getErrorTasks(): array
    {
        return $this->errorTasks;
    }

	public function toStdClass():\stdClass
    {
		$stdObj = new \stdClass();
		$stdObj->status = $this->status;
		$stdObj->ok_tasks = $this->okTasks;
		$stdObj->properties = $this->properties;
		$stdObj->warnings = $this->warningTasks;
		$stdObj->errors = $this->errorTasks;
		return $stdObj;
    }
}