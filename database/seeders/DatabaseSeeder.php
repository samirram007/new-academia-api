<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Country::create([
            'country_code' => 'IN',
            'name' => 'INDIA',
        ]);
        \App\Models\State::create([
            'state_code' => 'WB',
            'name' => 'WEST BENGAL',
            'country_id' => 1,
        ]);
        \App\Models\Address::create([
            'address_line_1' => fake()->streetAddress,
            'address_type' => 'permanent',
            'state_id' => 1,
            'country_id' => 1,
        ]);
        \App\Models\SchoolType::create([
            'name' => 'HINDI MEDIUM'
        ]);
        \App\Models\EducationBoard::create([
            'name' => 'West Bengal Board Of Secondary Education',
            'code' => 'WBBSE',
        ]);
        \App\Models\School::create([
            'name' => 'Navajyoti Vidyapith',
            'code' => 'NV',
            'school_type_id' => 1,
            'education_board_id' => 1,
        ]);
        \App\Models\Campus::create([
            'name' => 'Primary Section',
            'code' => 'PC',
            'school_id' => 1,
            'education_board_id' => 1,
        ]);
        \App\Models\Campus::create([
            'name' => 'Secondary Section',
            'code' => 'SC',
            'school_id' => 1,
            'education_board_id' => 1,
        ]);
        \App\Models\AcademicSession::create([
            'session' => '2024',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'campus_id' => 1,
        ]);
        \App\Models\AcademicSession::create([
            'session' => '2024',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'campus_id' => 2,
        ]);


        $this->call([
            UserSeeder::class,
        ]);
    }
}
