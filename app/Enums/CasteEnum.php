<?php
namespace App\Enums;


enum CasteEnum:string
{
    case GENERAL='general';


    case SC='sc';
    case ST='st';
    case OBC='obc';
    case OTHER = 'other';


    public function label(): string
    {
        return match($this){
            self::GENERAL => 'General',
            self::SC => 'SC',
            self::ST => 'ST',
            self::OBC => 'OBC',
            self::OTHER => 'Other',

        };
    }
    public static function default(): string
    {
        return  CasteEnum::SC->value;
    }
    public static function labels():array
    {
        return array_reduce(self::cases(),function($items, CasteEnum $item){
            $items[$item->value] = $item->name;
            return $items;
        },[]);
    }
    public static function dataLabels():array
    {
        return array_reduce(self::cases(),function($items, CasteEnum $item){
            $items[$item->value] = $item->name;
            return $items;
        },[]);
    }
}

