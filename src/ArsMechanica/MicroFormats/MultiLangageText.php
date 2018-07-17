<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 06.04.2017
 * Time: 14:44
 */

namespace ArsMechanica\MicroFormats;


class MultiLanguageText
{
    //public static $GlobalLanguageList;

    private $LanguageTexts;

    public function getLanguageText(?string $language):string
    {
        if($language === NULL) {
            //ToDo $language - получить из реесра сеанса язык по умолчанию
        }
        if(!in_array($language, $this->LanguageList)) {
            //ToDo вернуть ошибку об отвутствии перевода
        }
        return $this->LanguageTexts[$language];
    }

    public function setLanguageText(string $langauge, string $text):void
    {
        $this->LanguageTexts[$langauge] = $text;
    }

    public function getAllLanguages():array
    {
        return array_keys($this->LanguageList);
    }
}