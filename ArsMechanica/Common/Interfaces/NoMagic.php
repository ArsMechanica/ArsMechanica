<?php
declare(strict_types=1);
declare(encoding='UTF-8');

namespace ArsMechanica\Interfaces;


trait NoMagic {
    final public function __get($property_name_str) {
        throw new \Exception('It is forbidden to get undefined property in "' . __CLASS__ . '" Class/Запрещено обращаться к неотпределенным свойства в классе "' . __CLASS__ . '"');
        }

    final public function __set($property_name_str, $value) {
        throw new \Exception('It is forbidden to set undefined property in "' . __CLASS__ . '" Class/Запрещено задавать  неотпределенные свойства в классе "' . __CLASS__ . '"');
        }

    final public function __isset($property_name_str) {
        throw new \Exception('It is forbidden to get undefined property in "' . __CLASS__ . '" Class/Запрещено обращаться к неотпределенным свойства в классе "' . __CLASS__ . '"');
        }

    final public function __unset($property_name_str) {
        throw new \Exception('It is forbidden to unset undefined property in "' . __CLASS__ . '" Class/Запрещено удалять необъявленные свойства в классе "' . __CLASS__ . '"');
        }

    final public function __call($method_name_str, $arg_mix_array) {
        throw new \Exception('It is forbidden to call undefined method in "' . __CLASS__ . '" Class/Запрещено вызывать неопределенные методы в классе "' . __CLASS__ . '"');
        }
    }