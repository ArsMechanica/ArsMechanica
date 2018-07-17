<?php
/**
 * Created by PhpStorm.
 * User: Arsik
 * Date: 1/25/2018
 * Time: 10:39 PM
 */

namespace ArsMechanica\Common;


trait Parametrable
{
    private $properties = [];

    public function addProp($key, $value):void
    {
        $this->properties[$key] = $value;
    }

    public function isSetProp($key)
    {
        return array_key_exists ($key, $this->properties[$key]);
    }

    public function getProp($key)
    {
        return $this->properties[$key];
    }

    public function getProps()
    {
        return $this->properties;
    }

}