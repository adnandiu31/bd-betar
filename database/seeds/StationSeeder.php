<?php

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Rajshahi',
            'address' => 'Bangladesh Betar, Rajshahi'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Rangpur',
            'address' => 'Bangladesh Betar, Rangpur'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Khulna',
            'address' => 'Bangladesh Betar, Khulna'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Agrabad, Chittagong',
            'address' => 'Bangladesh Betar, Agrabad, Chittagong'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Sylhet',
            'address' => 'Bangladesh Betar, Sylhet'
        ]);
        Station::updateOrCreate([
            'name' => 'High Power Transmitting Station-1, Bangladesh Betar, Savar, Dhaka',
            'address' => 'Savar, Dhaka-1343'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, hpt2 Savar, Dhaka',
            'address' => 'Savar, Dhaka-1343'
        ]);
        Station::updateOrCreate([
            'name' => 'LPT, Bangladesh Betar, Kalyanpur, Dhaka',
            'address' => 'LPT, Bangladesh Betar, Kalyanpur, Dhaka'
        ]);
        Station::updateOrCreate([
            'name' => 'SPT, Bangladesh Betar, Dhamrai, Dhaka',
            'address' => 'SPT, Bangladesh Betar, Dhamrai, Dhaka'
        ]);
        Station::updateOrCreate([
            'name' => 'NBH, Bangladesh Betar, Dhaka',
            'address' => 'She-E-Bangla Nagar, Dhaka-1207'
        ]);
        Station::updateOrCreate([
            'name' => ' HPT-5, Bangladesh Betar, Bogura',
            'address' => 'HPT-5, Bangladesh Betar, Bogura'
        ]);
        Station::updateOrCreate([
            'name' => 'Old BH, Bangladesh Betar, Dhaka',
            'address' => ' 121, Kazi Nazrul Islam Avenue, Dhaka-1000'
        ]);
        Station::updateOrCreate([
            'name' => 'HPT-3, Bangladesh Betar, Nowapara, Jessore',
            'address' => 'HPT-3, Bangladesh Betar, Nowapara, Jessore'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Bandarbon',
            'address' => 'Bangladesh Betar, Bandarbon'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Comilla',
            'address' => 'Bangladesh Betar, Comilla'
        ]);
        Station::updateOrCreate([
            'name' => 'Central Storem Bangladesh Betar, Pahartoli, Chittagong',
            'address' => 'Central Store, Bangladesh Betar, Pahartoli, Chittagong'
        ]);
        Station::updateOrCreate([
            'name' => 'Transcription Service, Bangladesh Betar, Shahbag, Dhaka',
            'address' => ' 121, Kazi Nazrul Islam Avenue, Dhaka-1000'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Barishal',
            'address' => 'Bangladesh Betar, Barishal'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Thakurgaon',
            'address' => 'Bangladesh Betar, Thakurgaon'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Rangamati',
            'address' => 'Bangladesh Betar, Rangamati'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Coxbazar',
            'address' => 'Bangladesh Betar, Coxbazar'
        ]);
        Station::updateOrCreate([
            'name' => 'Bangladesh Betar, Kobirpur, Savar, Dhaka',
            'address' => 'Bangladesh Betar, Kobirpur, Savar, Dhaka'
        ]);
        Station::updateOrCreate([
            'name' => 'HPT-4, Bangladesh Betar, Kalurghat, Chattogram',
            'address' => 'HPT-4, Bangladesh Betar, Kalurghat, Chittagong'
        ]);
    }
}
