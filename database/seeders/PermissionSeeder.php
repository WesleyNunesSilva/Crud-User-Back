<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parent1 = Permission::create([
            'name' => 'Permissão pai 1',
            'parent_id' => null,
        ]);

        $parent2 = Permission::create([
            'name' => 'Permissão pai 2',
            'parent_id' => null,
        ]);

        // Permissões filhas
        Permission::create([
            'name' => 'Permissão filha 1',
            'parent_id' => $parent1->id,
        ]);

        Permission::create([
            'name' => 'Permissão filha 2',
            'parent_id' => $parent1->id,
        ]);

        Permission::create([
            'name' => 'Permissão filha 3',
            'parent_id' => $parent2->id,
        ]);
    }
}
