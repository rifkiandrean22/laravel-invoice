<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {
    public function run(): void {
        foreach (['admin','purchasing','finance'] as $role) {
            Role::findOrCreate($role);
        }
    }
}
