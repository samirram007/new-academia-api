<?php

namespace App\Models;

use App\Models\User;
use App\Models\State;
use App\Models\Country;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'house_no',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'village',
        'post_office',
        'rail_station',
        'police_station',
        'district',
        'state_id',
        'country_id',
        'pincode',
        'latitude',
        'longitude',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class)->withDefault();
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function display()
    {
        $parts = [
            $this->house_no,
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->village,
            $this->post_office,
            $this->rail_station,
            $this->police_station,
            $this->district,
            $this->pincode,
            $this->state?->name, // Use null-safe operator for relationships
            $this->country?->name, // Use null-safe operator for relationships
        ];
        // Filter out null or empty values
        $filteredParts = array_filter($parts, fn($part) => !empty($part));

        // Join the non-empty parts with ', '
        return implode(', ', $filteredParts);
    }

}
