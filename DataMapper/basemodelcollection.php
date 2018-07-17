<?php
namespace DataMapper;

class BaseModelCollection extends \DataMapper\AbstractCollection {

	function targetClass() {
		return '\DomainModel\BaseModel';
		}
	}