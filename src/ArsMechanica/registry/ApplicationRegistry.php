<?php
namespace ArsMechanica\Registry;
class ApplicationRegistry extends AbstractRegistry {

private static $instance_obj;
private $freezdir_str	= "data/";
private $values_arr		= array();
private $mtimes_arr		= array();

private function __construct() {}

static function getInstance() {
	if(!isset(self::$instance_obj)) {
		self::$instance_obj = new self();
		}
	return self::$instance_obj;
	}
	
public function get($key_mix) {
	$path_str = DIR . $this->freezdir_str . $key_mix;
	echo $path_str;
	if(file_exists($path_str)) {
        clearstatcache();
        $mtime_int = filemtime($path_str);

        if (!isset($this->mtimes_arr[$key_mix])) {
            $this->mtimes_arr[$key_mix] = 0;
        }
        if ($mtime_int > $this->mtimes_arr[$key_mix]) {
            $data_mix = file_get_contents($path_str);
            $this->mtimes_arr[$key_mix] = $mtime_int;
            return ($this->values_arr[$key_mix] = unserialize($data_mix));
        }
        if (isset($this->values_arr[$key_mix])) {
            return $this->values_arr[$key_mix];
        }
    }
	return NULL;
	}

	public function isSet($key):bool {

    }

    public function unset($key):void {

    }
	
public function set($key_mix, $value_mix):void {
	$this->values_arr[$key_mix] = $value_mix;
	$path_str = DIR . $this->freezdir_str . $key_mix;
	file_put_contents($path_str, serialize($value_mix));
	$this->mtimes_arr[$key_mix] = time();
	}

static function getDSN() {
	return self::getInstance()->get('dsn');
	}

static function setDSN($Dsn) {
	return self::getInstance()->set('dsn', $Dsn);
	}
}