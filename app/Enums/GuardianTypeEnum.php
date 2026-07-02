<?php

namespace App\Enums;


enum GuardianTypeEnum:string
{
    case FATHER='father';
    case MOTHER='mother';
    case OTHER='other';


    public function label(): string
    {
        return match($this){
            self::FATHER => 'Father',
            self::MOTHER => 'Mother',
            self::OTHER => 'Other',

        };
    }
    public static function default(): string
    {
        return  GuardianTypeEnum::FATHER->value;
    }
    public static function labels():array
    {
        return array_reduce(self::cases(),function($items, GuardianTypeEnum $item){
            $items[$item->value] = $item->label();
            return $items;
        },[]);
    }
    public static function dataLabels():array
    {
        return array_reduce(self::cases(),function($items, GuardianTypeEnum $item){
            $items[$item->value] = $item->name;
            return $items;
        },[]);
    }
}

