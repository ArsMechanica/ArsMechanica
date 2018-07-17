<?php
namespace DomainModel;

class Event extends Node {
	protected $strat_date_obj;
	protected $end_date_obj;
	protected $number_of_participants_int;
	
	protected function __construct() {
		parent::__construct();
		}

	public static function create() {
		return new \DomainModel\Event();
		}

public function toStdClass() {
	$stdObj = parent::toStdClass();
	
	return $stdObj;
	}
/* */
}