<?php
namespace ArsMechanica\Interfaces;

interface Iterator {
	//public function CreateItertor();
	public function getSize();
	public function rewind();
	public function getNextItem();
	public function hasNext();
	public function getCurrentItem();
	public function getCurrentIndex();
	}