<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        'admin_role' => 'administrator',
//        'manager_role' => 'manager',
//        'default_role' => 'user',
//        'cashier_role' => 'cashier',
//        'sales_ref' => 'ref',

        Role::create(['name' => config('app.users.admin_role')]);
        Role::create(['name' => config('app.users.manager_role')]);
        Role::create(['name' => config('app.users.default_role')]);
        Role::create(['name' => config('app.users.cashier_role')]);
        Role::create(['name' => config('app.users.sales_ref')]);


        //permissons
        $persmissions = [
            'create_user',
            'remove_user',
            'modify_user',
            'view_users',
            'create_supplier',
            'modify_supplier',
            'remove_supplier',
            'view_order_history',
            'add_product',
            'modify_product',
            'view_product_history',
            'view_products',
            'add_stock',
            'remove_stock',
            'view_stock',
            'stock_assignment',
            're_order_stock',
            'create_purchase_order',
            'view_purchase_order',
            'register_suppliers',
            'view_suppliers',
            'view_reports',
            'create_sales_order',
            'register_customer',
            'view_customer',
            'remove_customer',
            'modify_customer',
            'manage_warranties',
            'role_management',
            'sales_overview',
            'create_sales_quotation',
        ];


        //cashier default permissions
        $cashier_permissions = [
            'create_sales_order',
            'register_customer',
            'view_customer',
            'view_stock',
            'stock_assignment'
        ];


        $ref_permissions = [
            'create_sales_order',
            'register_customer',
            'view_customer',
        ];


        $manager_permissions = $persmissions;

        $default_permissions = $cashier_permissions;


        $permissions = collect($persmissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());


        //setting permissions for roles

        //admin role

        $admin = Role::findByName(config('app.users.admin_role'));

        foreach ($persmissions as $permission) {
            $admin->givePermissionTo($permission);
        }


        //manager permissions
        $manager = Role::findByName(config('app.users.manager_role'));

        foreach ($manager_permissions as $manager_permission) {
            $manager->givePermissionTo($manager_permission);
        }

        // cahier permissions
        $cashier = Role::findByName(config('app.users.cashier_role'));

        foreach ($cashier_permissions as $cashier_permission) {
            $cashier->givePermissionTo($cashier_permission);
        }

        User::find(1)->assignRole(config('app.users.admin_role'));


    }
}
