<?php

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $business = Business::create([
            'name' => 'My Test Business',
            'email' => 'admin@mybusiness.com',
            'logo' => '/images/Abno logo.jpg',
            'domain' => 'http://127.0.0.1:8000/',
            'initials' => 'MTB'
        ]);

        $role = Role::create([
            'business_id' => $business->id,
            'name' => 'Admin myBusiness',
            'status' => true
        ]);
        User::create([
            'email' => $business->email,
            'password' => bcrypt('secret123'),
            'business_id' => $business->id,
            'name' => 'MyBusiness admin',
            'role_id' => $role->id,
            'primary_role' => 'Super_admin',
            'isBusinessAccount' => true
        ]);
    }
}
