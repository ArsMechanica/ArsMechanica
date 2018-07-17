<?php
namespace ArsMechanica\Controller;

use ArsMechanica\Registry\ApplicationRegistry;

class ApplicationHelper
{
    use \ArsMechanica\Interfaces\Singleton;

	private $config_str = '';

	protected function __construct() {}

	function init()
    {
		$dsn = ApplicationRegistry::getDSN();
		if(!is_null($dsn)) {
			return;
        }
		$this->getOptions();
    }
	
	private function getOptions()
    {
		$this->ensure(file_exists($this->config_str), 'Configuration file not found');
		$options_xml = @SimpleXml_load_file($this->config_str);
		$dsn_str = (string)$options_xml->dsn;
		$this->ensure($options_xml instanceof SimpleXMLElement, 'Configuration file not found is corrupted');
		$this->ensure($dsn_str, 'DSN not found');
		$dsn = ApplicationRegistry::setDSN($dsn_str);
    }
	
	private function ensure($expr, $message_str)
    {
		if(!$expr) {
			//throw new \AppException($message_str);
        }
    }
}
