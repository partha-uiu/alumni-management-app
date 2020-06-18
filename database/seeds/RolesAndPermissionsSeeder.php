<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        Permission::truncate();

        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'create admin']);
        Permission::create(['name' => 'edit admin']);
        Permission::create(['name' => 'delete admin']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'approve user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'create editor']);
        Permission::create(['name' => 'approve editor']);
        Permission::create(['name' => 'edit editor']);
        Permission::create(['name' => 'delete editor']);

        Permission::create(['name' => 'create donation']);
        Permission::create(['name' => 'approve donation']);
        Permission::create(['name' => 'edit donation']);
        Permission::create(['name' => 'delete donation']);

        Permission::create(['name' => 'create event']);
        Permission::create(['name' => 'approve event']);
        Permission::create(['name' => 'edit event']);
        Permission::create(['name' => 'delete event']);

        Permission::create(['name' => 'create job']);
        Permission::create(['name' => 'approve job']);
        Permission::create(['name' => 'edit job']);
        Permission::create(['name' => 'delete job']);

        Permission::create(['name' => 'create news']);
        Permission::create(['name' => 'edit news']);
        Permission::create(['name' => 'delete news']);

        Permission::create(['name' => 'create mentorship topics']);
        Permission::create(['name' => 'edit mentorship topics']);
        Permission::create(['name' => 'delete mentorship topics']);

        Permission::create(['name' => 'view alumni directory']);

        // create roles and assign existing permissions

        //roles for supper admin
        $role = Role::create(['name' => 'super-admin']);

        $role->givePermissionTo('create admin');
        $role->givePermissionTo('edit admin');
        $role->givePermissionTo('delete admin');

        $role->givePermissionTo('view user');
        $role->givePermissionTo('approve user');
        $role->givePermissionTo('edit user');
        $role->givePermissionTo('delete user');

        $role->givePermissionTo('create editor');
        $role->givePermissionTo('approve editor');
        $role->givePermissionTo('edit editor');
        $role->givePermissionTo('delete editor');

        $role->givePermissionTo('create donation');
        $role->givePermissionTo('approve donation');
        $role->givePermissionTo('edit donation');
        $role->givePermissionTo('delete donation');

        $role->givePermissionTo('create event');
        $role->givePermissionTo('approve event');
        $role->givePermissionTo('edit event');
        $role->givePermissionTo('delete event');

        $role->givePermissionTo('create job');
        $role->givePermissionTo('approve job');
        $role->givePermissionTo('edit job');
        $role->givePermissionTo('delete job');

        $role->givePermissionTo('create news');
        $role->givePermissionTo('edit news');
        $role->givePermissionTo('delete news');

        $role->givePermissionTo('create mentorship topics');
        $role->givePermissionTo('edit mentorship topics');
        $role->givePermissionTo('delete mentorship topics');

        $role->givePermissionTo('view alumni directory');

        //roles for admin
        $role = Role::create(['name' => 'admin']);

        $role->givePermissionTo('view user');
        $role->givePermissionTo('approve user');
        $role->givePermissionTo('edit user');
        $role->givePermissionTo('delete user');

        $role->givePermissionTo('create editor');
        $role->givePermissionTo('approve editor');
        $role->givePermissionTo('edit editor');
        $role->givePermissionTo('delete editor');

        $role->givePermissionTo('create donation');
        $role->givePermissionTo('approve donation');
        $role->givePermissionTo('edit donation');
        $role->givePermissionTo('delete donation');

        $role->givePermissionTo('create event');
        $role->givePermissionTo('approve event');
        $role->givePermissionTo('edit event');
        $role->givePermissionTo('delete event');

        $role->givePermissionTo('create job');
        $role->givePermissionTo('approve job');
        $role->givePermissionTo('edit job');
        $role->givePermissionTo('delete job');

        $role->givePermissionTo('create news');
        $role->givePermissionTo('edit news');
        $role->givePermissionTo('delete news');

        $role->givePermissionTo('create mentorship topics');
        $role->givePermissionTo('edit mentorship topics');
        $role->givePermissionTo('delete mentorship topics');

        $role->givePermissionTo('view alumni directory');

        //roles for editor
        $role = Role::create(['name' => 'editor']);

        $role->givePermissionTo('create donation');
        $role->givePermissionTo('approve donation');
        $role->givePermissionTo('edit donation');
        $role->givePermissionTo('delete donation');

        $role->givePermissionTo('create event');
        $role->givePermissionTo('approve event');
        $role->givePermissionTo('edit event');
        $role->givePermissionTo('delete event');

        $role->givePermissionTo('create job');
        $role->givePermissionTo('approve job');
        $role->givePermissionTo('edit job');
        $role->givePermissionTo('delete job');

        $role->givePermissionTo('create news');
        $role->givePermissionTo('edit news');
        $role->givePermissionTo('delete news');

        $role->givePermissionTo('view alumni directory');

        //roles for faculty-stuff
        $role = Role::create(['name' => 'faculty-stuff']);

        $role->givePermissionTo('create donation');
        $role->givePermissionTo('approve donation');
        $role->givePermissionTo('edit donation');
        $role->givePermissionTo('delete donation');

        $role->givePermissionTo('create event');
        $role->givePermissionTo('approve event');
        $role->givePermissionTo('edit event');
        $role->givePermissionTo('delete event');

        $role->givePermissionTo('create job');
        $role->givePermissionTo('approve job');
        $role->givePermissionTo('edit job');
        $role->givePermissionTo('delete job');

        $role->givePermissionTo('create news');
        $role->givePermissionTo('edit news');
        $role->givePermissionTo('delete news');

        //roles for alumni
        $role = Role::create(['name' => 'alumni']);

        $role->givePermissionTo('view user');
        $role->givePermissionTo('approve user');

        $role->givePermissionTo('create donation');

        $role->givePermissionTo('create event');

        $role->givePermissionTo('create job');

        $role->givePermissionTo('view alumni directory');

        //roles for students
        $role = Role::create(['name' => 'student']);
        $role->givePermissionTo('view alumni directory');
    }
}
