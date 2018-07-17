<?php
namespace Controller;
class Task 
implements \Interfaces\toJSONable {
	protected $taskName		= NULL;
	protected $status		= 'Started';		//'Started', 'Ok', 'warning', 'error'
	protected $result		= 'Успешно выполнено';
	
	public function __construct($taskName) {
		$this->taskName = $taskName;
		}
		
	public function setTaskName($taskName) {
		$this->taskName = $taskName;
		}
		
	public function getTaskName() {
		return $this->taskName;
		}
		
	public function setStatus($status) {
		$acceptableStatuses = ['Started', 'Ok', 'warning', 'error'];
		if(!in_array($acceptableStatuses, $status)) {
			throw new \Exception('Неправильный статус у задачи')ж
			}
		$this->status = $status;
		}

	public function getStatus() {
		return $this->status;
		}
	
	public function setTaskResult($result) {
		$this->result = $result;
		}
	
	public function getTaskResult() {
		return $this->result;
		}
		
	public function setOk($okText) {
		$this->status = 'Ok';
		$this->result = $okText;
		}
		
	public function setError($errorText) {
		$this->status = 'error';
		$this->result = $errorText;
		}
		
	public function setWarring($warrningText) {
		if( $this->status != 'error' ) {
			$this->status = 'warning';
			}
		$this->status = 'error';
		$this->result = $warrningText;
		}
	
	public function toStdClass() {
		$stdObj = new \stdClass;

		return $stdObj;
		}
	
	final public function toJSON() {
		return json_encode($this->toStdClass());
		}
		
	/*magic methods*/
	function __get($property_name_str) {
		throw new \Exception('It is forbidden to get undefined property in Task Class/Запрещено обращаться к неотпределенным свойства в классе Task');
		}
		
	function __set($property_name_str, $value) {
		throw new \Exception('It is forbidden to set undefined property in Task Class/Запрещено задавать  неотпределенные свойства в классе Task');
		}
		
	function __isset($property_name_str) {
		throw new \Exception('It is forbidden to get undefined property in Task Class/Запрещено обращаться к неотпределенным свойства в классе Task');
		}
		
	function __unset($property_name_str) {
		throw new \Exception('It is forbidden to unset undefined property in Task Class/Запрещено удалять необъявленные свойства в классе Task');
		}
		
	function __call($method_name_str, $arg_mix_array) {
		throw new \Exception('It is forbidden to call undefined method in Task Class/Запрещено вызывать неопределенные методы в классе Task');
		}
	/* */
	}