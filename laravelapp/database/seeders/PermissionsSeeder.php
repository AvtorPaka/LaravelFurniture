<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $customer = Role::create(['name' => 'customer']);

        $goodsCreate = Permission::create([
            'name' => 'goods.create'
        ]);

        $goodsUpdate = Permission::create([
            'name' => 'goods.update'
        ]);

        $goodsDelete = Permission::create([
            'name' => 'goods.delete'
        ]);

        $categoriesCreate = Permission::create([
            'name' => 'categories.create'
        ]);

        $categoriesUpdate = Permission::create([
            'name' => 'categories.update'
        ]);

        $categoriesDelete = Permission::create([
            'name' => 'categories.delete'
        ]);

        $categoriesAllView = Permission::create([
            'name' => 'categories.view.all'
        ]);

        $usersView= Permission::create([
            'name' => 'users.view'
        ]);

        $usersDelete = Permission::create([
            'name' => 'users.delete'
        ]);

        $usersUpdateRole = Permission::create([
            'name' => 'users.update-role'
        ]);

        $cartView = Permission::create([
            'name' => 'cart.view'
        ]);

        $cartUpdate = Permission::create([
           'name' => 'cart.update'
        ]);

        $orderViewGlobal = Permission::create([
            'name' => 'order.view.global'
        ]);

        $orderViewLocal = Permission::create([
            'name' => 'order.view.local'
        ]);

        $orderCreate = Permission::create([
            'name' => 'order.create'
        ]);

        $orderModify= Permission::create([
            'name' => 'order.modify'
        ]);

        $ratingsModify = Permission::create([
            'name' => 'ratings.modify'
        ]);

        $admin->givePermissionTo(Permission::all());

        $customer->givePermissionTo($cartView, $cartUpdate, $orderViewLocal, $orderCreate, $ratingsModify);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
