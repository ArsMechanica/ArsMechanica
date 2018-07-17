<?php
namespace ArsMechanica\Interfaces;

use \stdClass;

trait toJSONable {
	public abstract function toStdClass():stdClass;

    final public function toJSON():string {
        return json_encode($this->toStdClass());
        }

    final public function __toString():string {
        return json_encode($this->toStdClass());
    }
}