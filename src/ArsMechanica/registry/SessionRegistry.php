<?php
namespace ArsMechanica\Registry;

class SessionRegistry extends AbstractRegistry  {
    use \ArsMechanica\Interfaces\Singleton;

    private function __construct() {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
            }
        }

    public function get($key) {
        if(self::getInstance()->isSet($key)) {
            return $_SESSION[__CLASS__][$key];
            }
        return NULL;
        }
	
    public function set($key, $value):void {
        $_SESSION[__CLASS__][$key] = $value;
        }

    public function isSet($key):bool {
        return isset($_SESSION[__CLASS__][$key]);
        }

    public function unset($key):void {
        if(self::getInstance()->isSet($key)) {
            $this->unset($_SESSION[__CLASS__][$key]);
        }
    }

    static function setLanguage($lang_code_str) {
        return self::getInstance()->set('lang_code', $lang_code_str);
        }

    static function getComplex() {
        return self::getInstance()->get('complex');
        }

    static function setRequest(Complex $Complex) {
        return self::getInstance()->set('complex', $Complex);
        }
    }