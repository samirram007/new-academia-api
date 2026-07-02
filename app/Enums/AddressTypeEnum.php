<?php
namespace App\Enums;


enum AddressTypeEnum: string
{
    case PERMANENT = 'permanent';
    case CURRENT = 'current';
    case OTHER = 'other';

    public static function default(): string
    {
        return AddressTypeEnum::PERMANENT->value;
    }
    public function label(): string
    {
        return match ($this) {
            self::PERMANENT => 'permanent',
            self::CURRENT => 'current',
            self::OTHER => 'other',
        };
    }
    public static function labels(): array
    {
        return array_reduce(self::cases(), function ($items, AddressTypeEnum $item) {
            $items[$item->value] = $item->label();
            return $items;
        }, []);
    }
    public static function dataLabels(): array
    {
        return array_reduce(self::cases(), function ($items, AddressTypeEnum $item) {
            $items[$item->value] = $item->name;
            return $items;
        }, []);
    }
}