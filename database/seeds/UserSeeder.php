<?php

use App\Models\Role;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create central admin
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'central-admin')->first()->id,
            'name' => 'Central Admin',
            'email' => 'centraladmin@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        // Create admin
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'admin')->first()->id,
            'station_id' => Station::find(1)->id,
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        // Create admin
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'admin')->first()->id,
            'station_id' => Station::find(1)->id,
            'name' => 'Admin',
            'email' => 'admin.kh@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        // Create Director General
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'director-general')->first()->id,
            'name' => 'Director General',
            'email' => 'dg@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        // Create Main Engineer
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'me')->first()->id,
            'name' => 'Main Engineer',
            'email' => 'me@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);
        // Create Central Engineer
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'central-engineer')->first()->id,
            'name' => 'Central Engineer',
            'email' => 'ce@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);
        // Create Central Engineer
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'ace')->first()->id,
            'name' => 'ACE',
            'email' => 'ace@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);
        // Create Central Engineer
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'se')->first()->id,
            'name' => 'SE',
            'email' => 'se@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);
        // Create Central Engineer
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'dse')->first()->id,
            'name' => 'DSE',
            'email' => 'dse@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        // Create Intent Officer
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'intent-officer')->first()->id,
            'station_id' => Station::find(1)->id,
            'name' => 'Indent Officer',
            'email' => 'io@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);


        // Create Station Head
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'station-head')->first()->id,
            'station_id' => Station::find(1)->id,
            'name' => 'Station Head',
            'email' => 'sh@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        // Create Station Incharge
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'station-incharge')->first()->id,
            'station_id' => Station::find(1)->id,
            'name' => 'Station Incharge',
            'email' => 'si@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        // Create Storekeeper
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'storekeeper')->first()->id,
            'station_id' => Station::find(1)->id,
            'name' => 'Storekeeper',
            'email' => 'sk@mail.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);
    }
}
