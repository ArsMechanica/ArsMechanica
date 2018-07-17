<?php
namespace DomainModel;

class Project extends Node {
	
	public function __construct() {
		parent::__construct();
		}

public function toStdClass() {
	$stdObj = parent::toStdClass();
	
	return $stdObj;
	}
/* */
}