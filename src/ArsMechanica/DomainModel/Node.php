<?php
namespace ArsMechanica\DomainModel;

use \ArsMechanica\DataMapper\NodeCollection;

class Node 
extends DomainObject

{
	protected $ParentBaseObj	= NULL;
	protected $order		= 0;
	protected $ChildrenList;	//\DataMapper\NodeCollection
	
	protected function __construct() {
		parent::__construct();
		$this->typeId			= 2;
		$this->typeName			= 'Node';
		$this->ChildrenList		= new NodeCollection();
		}
	
	public static function CreateShortForm() {
		$NewNode = new Node();
		return $NewNode;
		}


	public function setParent(\DomainModel\Node $Node) {
		$this->ParentBaseObj = $Node;
		}

public function getParent(): ?Node {
	return $this->ParentBaseObj;
	}

public function getParentId(): ?int {
    if(!$this->ParentBaseObj) {
        return $this->ParentBaseObj->getKey()->getId();
        }
	return NULL;
	}
	


public function getOrder() {
	return $this -> order_int;
	}

public function addChild(Node $additionalNode) {
	
	}

public function getChildrenList() {
	
	}

public function toStdClass() {
	$stdObj = parent::toStdClass();
	$stdObj -> parent_id = $this -> parent_obj_id;
	if($this->parent_base_model_obj instanceof BaseModel) {
		$stdObj -> parent = $this -> parent_base_model_obj->toStdClass();
		}
	$stdObj -> order = $this -> order_int;
	
	return $stdObj;
	}
/* */
}