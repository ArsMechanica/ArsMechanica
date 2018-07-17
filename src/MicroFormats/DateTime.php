<?php
namespace ArsMechanica\MicroFormats;

class DateTime 
{
    use \ArsMechanica\Interfaces\toJSONable;

	private $timestamp = NULL;
	private $dateTimeTemplate = 'Y-M-d';
	private $language = 'Ru';
	private $formatedDateTime = '';

    function __construct($timestampMix = NULL, $dateTimeTemplate = NULL) {
        $this->timestamp = self::convertMixToTimestamp($timestampMix);
        if($dateTimeTemplate != NULL) {
            $this->dateTimeTemplate = $dateTimeTemplate;
            }
        $this->formateDate();
        }

    public function setTimestamp($timestampMix) {
        $this->timestamp = self::convertMixToTimestamp($timestampMix);
        $this->formateDate();
        }

    public function getTimestamp() {
        return $this->timestamp;
        }

    public function resetTimestamp():void {
        $this->timestamp = NULL;
        $this -> formateDate();
    }

    public function setDateTimeTemplate(?str $dateTimeTemplate) {
        $this->dateTimeTemplate = $dateTimeTemplate;
    }

    public function getYear():int {
        return (int)date('Y', $this->timestamp);
    }

    public function getMonth():int {
        return (int)date('m', $this->timestamp);
    }

    public function getDay():int {
        return (int)date('d', $this->timestamp);
    }

    public function getFormatedDate() {
        return $this->formatedDateTime;
    }
	
    private static function convertMixToTimestamp($timestampMix): ?int {
        if(!is_null($timestampMix) AND !is_int($timestampMix) AND !is_string($timestampMix)) {
            throw new \Exception('Incorrect format of timestampmix');
            }

        switch (TRUE) {
            case(is_null($timestampMix)): {
                return NULL;
                }
            break;

            case($timestampMix === 'NOW()'): {
                return time();
                }
            break;

            case(is_int($timestampMix)): {
                return $timestampMix;
                }
            break;

            case((int)$timestampMix == $timestampMix): {
                return (int)$timestampMix;
                }
            break;

            case(is_string($timestampMix)): {
                return strtotime($timestampMix);
                }
            break;

            default: {
                throw new \Exception('Что-то не так');
                }
            break;
            }
        }


	
private function formateDate() {
	$converter_arr = array(
	'Sunday'	=> 'Воскресенье',
	'Monday'	=> 'Понедельник',
	'Tuesday'	=> 'Вторник',
	'Wednesday'	=> 'Среда',
	'Thursday'	=> 'Четверг',
	'Friday'	=> 'Пятница',
	'Saturday'	=> 'Суббота',
	'Sun'		=> 'Вс',
	'Mon'		=> 'Пн',
	'Tue'		=> 'Вт',
	'Wed'		=> 'Ср',
	'Thu'		=> 'Чт',
	'Fri'		=> 'Пт',
	'Sat'		=> 'Сб', 
	'January'	=> 'Январь',
	'February'	=> 'Февраль',
	'March'		=> 'Март',
	'April'		=> 'Апрель',
	'May'		=> 'Май',
	'June'		=> 'Июнь',
	'July'		=> 'Июль',
	'August'	=> 'Август',
	'September'	=> 'Сентябрь',
	'October'	=> 'Октябрь',
	'November'	=> 'Ноябрь',
	'December'	=> 'Декабрь',
	'Jan'		=> 'Янв',
	'Feb'		=> 'Фев',
	'Mar'		=> 'Мар',
	'Apr'		=> 'Апр',
	'May'		=> 'Май',	// Short representation of "May". May_short used because in English the short and long date are the same for May.
	'Jun'		=> 'Июн',
	'Jul'		=> 'Июл',
	'Aug'		=> 'Авг',
	'Sep'		=> 'Сен',
	'Oct'		=> 'Окт',
	'Nov'		=> 'Ноя',
	'Dec'		=> 'Дек'
	);
	
	if($this->timestamp == NULL) {
		$this->formatedDateTime = NULL;
		}
	elseif($this->language == 'Ru') {
		$this->formatedDateTime = strtr(date($this->dateTimeTemplate, $this -> timestamp), $converter_arr);
		}
	else {
		$this->formatedDateTime = date($this->dateTimeTemplate, $this->timestamp);
		}
	
	}

public function toStdClass():\stdClass {
	$stdObj = new \stdClass;
	$stdObj->timestamp		= $this -> timestamp;
	$stdObj->formatedDateTime	= $this -> formatedDateTime;
	
	return $stdObj;
	}
/*	*/
}