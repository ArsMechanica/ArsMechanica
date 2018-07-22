<?php
namespace ArsMechanica\Registry;

use ArsMechanica\Controller\Request;
\ArsMechanica\Interfaces\Singleton;


class RequestRegistry extends AbstractRegistry {

    use Singleton;

    private $RequestParametrList = [];

    private function __construct() {}
	
    public function get($key) {
        if($this->isSet($key)) {
            return $this->RequestParametrList[$key];
            }
        return NULL;
        }
	
    public function set($key, $value):void {
        $this->RequestParametrList[$key] = $value;
        }

	public function isSet($key):bool {
        if(array_key_exists($key, $this->RequestParametrList)) {
            return TRUE;
        }
        return NULL;
    }

    public function unset($key):void {
        unset($this->RequestParametrList[$key]);
    }

    static function getRequest():Request {
	    return self::getInstance()->get('request');
	    }

    static function setRequest(Request $Request) {
        return self::getInstance()->set('request', $Request);
        }
    }