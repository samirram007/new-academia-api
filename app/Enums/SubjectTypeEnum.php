<?php
namespace App\Enums;


enum SubjectTypeEnum:string
{
    case THEORY = 'theory';
    case PRACTICAL='practical';
    case THEORYnPRACTICAL='theory+practical';
    case SUBJECTIVE='subjective';
    case OBJECTIVE='objective';


    public function label(): string
    {
        return match($this){
            self::THEORY => 'Theory',
            self::PRACTICAL => 'Practical',
            self::THEORYnPRACTICAL => 'Theory & Practical',
            self::SUBJECTIVE => 'Subjective',
            self::OBJECTIVE => 'Objective',

        };
    }
    public static function default(): string
    {
        return  SubjectTypeEnum::THEORY->value;
    }
    public static function labels():array
    {
        return array_reduce(self::cases(),function($items, SubjectTypeEnum $item){
            $items[$item->value] = $item->label();
            return $items;
        },[]);
    }
    public static function dataLabels():array
    {
        return array_reduce(self::cases(),function($items, SubjectTypeEnum $item){
            $items[$item->value] = $item->name;
            return $items;
        },[]);
    }
}

