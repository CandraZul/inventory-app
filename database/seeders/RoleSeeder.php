<?php
namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder{
    public function run(){
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        $user1 = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole('admin');

        $user2 = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ]);
        $user2->assignRole('user');
    }
}
