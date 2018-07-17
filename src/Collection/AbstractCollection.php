<?php
namespace ArsMechanica\Collection;

abstract class AbstractCollection 
implements ArsMechanica\Interfaces\Iterator,
	ArsMechanica\Interfaces\toJSONable {
	protected $Maper;
	protected $count = 0;
	protected $raw = array();
	
	private $result;
	private $pointer_int = 0;
	private $objectsCollection = array();
	
	function __construct(array $raw_arr = null, \DataMapper\AbstractDataMapper $Mapper = null) {
		if(!is_null($raw) && !is_null($Mapper)) {
			$this -> raw_arr = $raw_arr;
			$this -> count_int = count($raw_arr);
			}
		$this -> Mapper = $Mapper;
		}
	
	function add(\DomainModel\BaseModel $AddedObject) {
		$class = $this->targetClass();
		if(!($AddedObject instanceof $class)) {
			throw new Exception('This is '.$class.'-Collection/Это коллекция для '.$class);
			}
		$this -> notifyAccess();
		$this -> objects_list_arr[$this -> count_int] = $AddedObject;
		$this -> count_int++;
		}
		
	function targetClass() {
		
		}
		
	protected function notifyAccess() {
		
		}
	
	private function getRow(int $num_int) {
		$this -> notifyAccess();
		if($num_int > $this->count_int || $num_int<0) {
			return null;
			}
		if(isset($this->objects_list_arr[$num_int])) {
			return $this->objects_list_arr[$num_int];
			}
		if(isset($raw_arr[$num_int])) {
			$this -> objects_list_arr[$num_int] = $this->mapper->createObject($raw_arr[$num_int]);
			return $this -> objects_list_arr[$num_int];
			}
		}
	
	public function getSize() {
		return $this -> count_int;
		}
	
	public function rewind() {
		$this -> pointer_int = 0;
		}
	
	public function getCurrentItem() {
		return $this -> objects_list_arr[$this -> pointer_int];
		}
		
	final public function getCurrentIndex() {
		return $this -> count_int;
		}
	
	public function getNextItem() {
		$row = $this($this->getRow($this -> pointer_int+1));
		if($row) {
			$this -> pointer_int++;
			}
		return $row;
		}
		
	public function hasNext() {
		return (!is_null($this->$this->getRow($this -> pointer_int + 1)));
		}
		
	public function toStdClass() {
		$array = array();
		foreach ($this -> objects_list_arr as $key => $value) {
			$array[$key] = $value -> toStdClass();
			}	
		return $array;
		}
		
	final public function toJSON() {
		return json_encode($this->toStdClass());
		}
	}