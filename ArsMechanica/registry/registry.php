<?php
namespace Registry;
abstract class Registry {
	abstract protected function get($key_mix);
	abstract protected function set($key_mix, $value_mix);
	}