<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddInitialRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        app()['cache']->forget('spatie.permission.cache');

        $access_admin_panel = Permission::firstOrCreate(['name' => 'access-admin-panel']);
        $read_internal_data = Permission::firstOrCreate(['name' => 'read-internal-data']);

        $r_admin = Role::firstOrCreate(['name' => 'admin']);
        $r_admin->givePermissionTo($access_admin_panel);
        $r_admin->givePermissionTo($read_internal_data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        app()['cache']->forget('spatie.permission.cache');

        Role::where('name', 'admin')->delete();
        Permission::where('name', 'access-admin-panel')->delete();
        Permission::where('name', 'read-internal-data')->delete();
    }
}
