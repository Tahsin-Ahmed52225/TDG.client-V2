<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissonSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'project-list',
            'project-show',
            'project-create',
            'project-edit',
            'project-delete',

            'project-members-edit',
            'project-files-edit',
            'project-task-read',
            'project-task-edit',
            'taskboard-view',

            'system-role',
            'system-log',

            'employee-manage',
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
