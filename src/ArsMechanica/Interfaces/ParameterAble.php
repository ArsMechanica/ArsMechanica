<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 2/26/2018
 * Time: 5:46 PM
 */

namespace ArsMechanica\Interfaces;


trait ParameterAble
{
    private $ParametersList = [];

    public function setProp($key, $value):void
    {
        $this->ParametersList[$key] = $value;
    }

    public function issetProp($key)
    {
        return in_array($key, $this->ParametersList);
    }
    
    public function addProp($key, $value):void
    {
		if (!$this->issetProp($key)) {
			$this->setProp($key, $value);
		}
	}

    public function getProp($key)
    {
        if(isset($this->ParametersList[$key])) {
            return $this->ParametersList[$key];
        }
        else {
            return null;
        }
    }

    public function getProps()
    {
        return $this->ParametersList;
    }
}