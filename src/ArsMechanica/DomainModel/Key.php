<?php
/**
* Identity Field Pattern
*/
namespace ArsMechanica\DomainModel;

class Key {
    use \ArsMechanica\Interfaces\toJSONable;

	protected $objId		= NULL;
	protected $projectId	= NULL;
	
	public function __construct($options = NULL) {
		if($options === NULL) {
			$this->setProjectId(PROJECT_ID);
			}
		else {
			if( array_key_exists('objId', $options)) {
				$this->setId($options['objId']);
				}
			if( array_key_exists('projectId', $options)) {
				$this->setProjectId($options['projectId']);
				}
			else {
				$this->setProjectId(PROJECT_ID);
				}
			}
		}

	public function	setId(int $id = NULL) {
		$this->objId = $id;
		}
	
	public function getId():int {
		return $this->objId;
		}
		
	protected function setProjectId(int $projectId) {
		$this->projectId = $projectId;
		}
		
	public function getProjectId():int {
		return $this->projectId;
		}
	
	public function getUniqueKey():int {
		return $this->projectId*1e8 + $this->objId;
		}
	
		
	public function equals(Key $AnotherKey) {
		if($this->getUniqueKey() === $AnotherKey->getUniqueKey()) {
			return TRUE;
			}
		else {
			return FALSE;
			}
		}


    public function toStdClass():\stdClass
    {
        $stdObj = new \stdClass();
        return $stdObj;
    }
}