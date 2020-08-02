<?php

use Illuminate\Database\Seeder;
use App\MercatodoModels\User;
use App\MercatodoModels\Role;
use App\MercatodoModels\Permission;
use Illuminate\Support\Facades\Hash;

class MercatodoPermissionInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user admin

        /* $useradmin= User::where('email','admin@admin.com' )->first();
         if ($useradmin) {
             $useradmin->delete();
         }*/

        $useradmin= User::create([

            'name'                  =>'admin',
            'surname'               =>'Eladmin',
            'identification'        =>'1152221469',
            'address'               =>'carrera 76 B # 54 38',
            'phone'                 =>'3173015596',
            'email'                 =>'admin@admin.com',
            'password'              =>Hash::make('admin123'),
        ]);

        //rol admin

        $roladmin= Role::create([
            'name'          =>'Admin',
            'slug'          =>'admin',
            'description'   =>'Administrator',
            'full-access'   =>'yes'

        ]);

        //rol User

        $roluser= Role::create([
            'name'          =>'User',
            'slug'          =>'user',
            'description'   =>'User client',
            'full-access'   =>'no'

        ]);

        //table role_user
        $useradmin->roles()->sync([ $roladmin->id ]);

        $permission_all = [];
        //permission role
        $permission = Permission::create([
            'name'          =>'List role',
            'slug'          =>'role.index',
            'description'   =>'A user can list role',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Show role',
            'slug'          =>'role.show',
            'description'   =>'A user can see role',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'create role',
            'slug'          =>'role.create',
            'description'   =>'A user can create role',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Edit role',
            'slug'          =>'role.edit',
            'description'   =>'A user can edit role',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Destroy role',
            'slug'          =>'role.destroy',
            'description'   =>'A user can destroy role',
        ]);

        $permission_all[] = $permission->id;




        //permission user
        $permission = Permission::create([
            'name'          =>'List user',
            'slug'          =>'user.index',
            'description'   =>'A user can list user',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Show user',
            'slug'          =>'user.show',
            'description'   =>'A user can see user',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Edit user',
            'slug'          =>'user.edit',
            'description'   =>'A user can edit user',
        ]);

        //$permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Destroy user',
            'slug'          =>'user.destroy',
            'description'   =>'A user can destroy user',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Show own user',
            'slug'          =>'userown.show',
            'description'   =>'A user can see own user',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name'          =>'Edit own user',
            'slug'          =>'userown.edit',
            'description'   =>'A user can edit own user',
        ]);

        //permission role
        $roladmin->permissions()->sync($permission_all);
    }
}
