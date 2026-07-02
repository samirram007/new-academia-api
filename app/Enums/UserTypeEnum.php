<?php
namespace App\Enums;


enum UserTypeEnum:string
{
    case ADMIN = 'admin';
    case DEVELOPER = 'developer';
    case SUPER_ADMIN = 'super_admin';
    case STUDENT = 'student';
    case GUARDIAN = 'guardian';
    case TEACHER = 'teacher';
    case EMPLOYEE = 'employee';
    case TRANSPORT_OWNER = 'transport_owner';
    case DRIVER = 'driver';
    case MANAGER ='manager';
    case PARENT = 'parent';
    case FACULTY = 'faculty';

    public function label(): string
    {
        return match($this){
            self::ADMIN => 'Admin',
            self::DEVELOPER => 'Developer',
            self::SUPER_ADMIN => 'Super Admin',
            self::STUDENT => 'Student',
            self::GUARDIAN => 'Guardian',
            self::TEACHER => 'Teacher',
            self::EMPLOYEE => 'Employee',
            self::TRANSPORT_OWNER => 'Transport Owner',
            self::DRIVER => 'Driver',
            self::MANAGER => 'Manager',
            self::PARENT => 'Parent',
            self::FACULTY => 'Faculty',
        };
    }
    public static function default(): string
    {
        return  UserTypeEnum::STUDENT->value;
    }
    public static function labels():array
    {
        return array_reduce(self::cases(),function($items, UserTypeEnum $item){
            $items[$item->value] = $item->label();
            return $items;
        },[]);
    }
    public static function dataLabels():array
    {
        return array_reduce(self::cases(),function($items, UserTypeEnum $item){
            $items[$item->value] = $item->name;
            return $items;
        },[]);
    }
}

