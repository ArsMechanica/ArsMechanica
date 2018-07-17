<?php
namespace DomainModel;

class Page extends Node {
	protected $translit_bl = FALSE;		//Переключатель автотранслита urldecode. По умолчанию включен.
	protected $url_str = ''; 			//Собственный url объекта Максимальная длинна - 200 символов. Кодировка utf-8. Уникальный в рамках родителя.
	protected $full_url_str = ''; 		//Полный url объекта. Максимальная длинна - 200 символов. Кодировка utf-8. Уникальный в рамках проекта.
	protected $short_text = '';		//Краткий текст объекта. Максимальная длинна - 65 535 символов. Кодировка utf-8.
	protected $full_text = '';			//Полный текст объекта. Максимальная длинна - 4 294 967 295 символов. Кодировка utf-8.
	protected $hidden_text = '';		//Скрытый текст объекта. Максимальная длинна - 65 535 символов. Кодировка utf-8.
	protected $big_img_url = NULL;		//Скрытый текст объекта. Максимальная длинна - 65 535 символов. Кодировка utf-8.
	protected $small_img_url = NULL;	
	
public function __construct() {
	parent::__construct();
	}

public function toStdClass() {
	$stdObj = parent::toStdClass();
	$stdObj -> parent_id = $this -> parent_obj_id;
	if($this->parent_base_model_obj instanceof BaseModel) {
		$stdObj -> parent = $this -> parent_base_model_obj->toStdClass();
		}
	$stdObj -> order = $this -> order_int;
	
	return $stdObj;
	}
/* */
}