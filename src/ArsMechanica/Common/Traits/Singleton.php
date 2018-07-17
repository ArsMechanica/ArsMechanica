<?php
namespace ArsMechanica\Co;
/**
 * Created by PhpStorm.
 * User: Arsik
 * Date: 31.10.2016
 * Time: 19:57
 */
trait Singleton {
    private static $Instance;

    protected function __construct() {

        }

    public static function getInstance() {
        if(empty(self::$Instance)) {
            self::$Instance = new self();
            }
        return self::$Instance;
        }

}