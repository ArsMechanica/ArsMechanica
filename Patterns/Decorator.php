<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 11/13/2017
 * Time: 10:28 PM
 */

namespace ArsMechanica\Patterns;


trait Decorator
{
    protected $DecoratedObject;

    public function __construct($DecoratedObject)
    {
        $this->DecoratedObject = $DecoratedObject;
    }

    public function __call($methodName, $argArr)
    {
        if (method_exists($this->DecoratedObject, $methodName)) {
            $this->DecoratedObject->$methodName($argArr);
        } else {
            throw new \Exception('Method not exists not in Decorator not in DecoratedObject');
        }
    }
}