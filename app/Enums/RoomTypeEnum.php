<?php
namespace App\Enums;

use Illuminate\Support\Str;


enum RoomTypeEnum:string
{

    case CLASS_ROOM = "class_room";
    case SCIENCE_LAB = "science_lab";
    case COMPUTER_LAB = "computer_lab";
    case GYMNASIUM = "gymnasium";
    case AUDITORIUM = "auditorium";
    case ART_ROOM = "art_room";
    case MUSIC_ROOM = "music_room";
    case CAFETERIA = "cafeteria";
    case ADMIN_OFFICE = "admin_office";
    case LIBRARY = "library";
    case WASH_ROOM = "wash_room";
    case SPECIAL_EDUCATION_ROOM = "special_education_room";
    case RESOURCE_ROOM = "resource_room";


    public function label(): string
    {
        return match($this){
            self::CLASS_ROOM => 'Class Room',
            self::SCIENCE_LAB => 'Science Lab',
            self::COMPUTER_LAB => 'Computer Lab',
            self::GYMNASIUM => 'Gymnasium',
            self::AUDITORIUM => 'Auditorium',
            self::ART_ROOM => 'Art Room',
            self::MUSIC_ROOM => 'Music Room',
            self::CAFETERIA => 'Cafeteria',
            self::ADMIN_OFFICE => 'Office Room',
            self::LIBRARY => 'Library',
            self::WASH_ROOM => 'Wash Room',
            self::SPECIAL_EDUCATION_ROOM => 'Special Education Room',
            self::RESOURCE_ROOM => 'Resource Room',
        };
    }
    public static function default(): string
    {
        return  RoomTypeEnum::CLASS_ROOM->value;
    }
    public static function labels():array
    {
        return array_reduce(self::cases(),function($items, RoomTypeEnum $item){
            $items[$item->value] = $item->label();
            return $items;
        },[]);
    }
    public static function dataLabels():array
    {
        return array_reduce(self::cases(),function($items, RoomTypeEnum $item){
            //$items[Str::snake($item->label())] = $item->name;
           $items[$item->value] = $item->name;
            return $items;
        },[]);
    }
}

