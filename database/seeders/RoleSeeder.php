<?php
namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder{
    public function run(){
        $super_admin = Role::firstOrCreate(['name' => 'super admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $dosen = Role::firstOrCreate(['name' => 'dosen']);
        $mahasiswa = Role::firstOrCreate(['name' => 'mahasiswa']);

        $user1 = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole($super_admin);

        $user2 = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $user2->assignRole($admin);

        $user3 = User::firstOrCreate([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
            'password' => bcrypt('password')
        ]);
        $user3->assignRole($dosen);

        $user1 = User::firstOrCreate([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@example.com',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole($mahasiswa);
    }
}
