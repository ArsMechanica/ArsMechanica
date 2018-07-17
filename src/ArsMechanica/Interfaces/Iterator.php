<?php
namespace ArsMechanica\Interfaces;

trait Iterator {
	//public function CreateItertor();
	public function addItem(){}
	public function getSize(): int {}
	public function rewind(){}
	public function getNextItem(){}
	public function hasNext(){}
	public function getCurrentItem(){}
	public function getCurrentIndex(){}
	}