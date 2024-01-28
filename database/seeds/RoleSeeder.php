<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::updateOrCreate(['name' => 'Central Admin', 'slug' => 'central-admin', 'deletable' => false])
            ->permissions()
            ->sync($admin_permissions->pluck('id'));

        Role::updateOrCreate(['name' => 'Admin', 'slug' => 'admin', 'deletable' => false])
            ->permissions()
            ->sync($admin_permissions->pluck('id'));

        Role::updateOrCreate(['name' => 'Director General', 'slug' => 'director-general', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'Central Engineer', 'slug' => 'central-engineer', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'ACE', 'slug' => 'ace', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'ME', 'slug' => 'me', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'SE', 'slug' => 'se', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'DSE', 'slug' => 'dse', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'Indent Officer', 'slug' => 'intent-officer', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'Station Head', 'slug' => 'station-head', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'Station Incharge', 'slug' => 'station-incharge', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'Storekeeper', 'slug' => 'storekeeper', 'deletable' => false]);
    }
}
