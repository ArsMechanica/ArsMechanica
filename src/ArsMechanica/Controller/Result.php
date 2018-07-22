<?php
namespace ArsMechanica\Controller;

use \ArsMechanica\Controller\Task;

class Result
{
    use \ArsMechanica\Interfaces\Singleton;
    use \ArsMechanica\Interfaces\toJSONable;
    use \ArsMechanica\Interfaces\ParameterAble;
    use \ArsMechanica\Interfaces\NoMagic;


	protected $status		= 'started';		//'Ok', 'warning', 'error'
    protected $command      = null;
    protected $header       = '';
	protected $properties	= [];
	protected $okTasks 		= [];
	protected $warningTasks = [];
	protected $errorTasks 	= [];
	protected $outputType 	= 'web';

	public function setOutputType(string $outputType):void {
	    $this->outputType = $outputType;
    }

    public function getOutputType():string {
        return $this->outputType;
    }


    public function setHeader(string $header)
    {
        $this->header = $header;
    }

    public function getHeader(): string
    {
        return $this->header;
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
		$stdObj->header = $this->header;
		$stdObj->ok_tasks = $this->okTasks;
		$stdObj->properties = $this->getProps();
		$stdObj->warnings = $this->warningTasks;
		$stdObj->errors = $this->errorTasks;
		return $stdObj;
    }
}