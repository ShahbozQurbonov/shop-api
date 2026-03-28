<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ҳамаи permission-ҳо
        $permissions = [

            // roles
            'role:viewAny', 'role:view', 'role:assign', 'role:create', 'role:update', 'role:delete', 'role:restore',

            // permissions
            'permission:viewAny', 'permission:view', 'permission:assign', 'permission:create', 'permission:update', 'permission:delete', 'permission:restore',

            // users
            'user:viewAny', 'user:view', 'user:create', 'user:update', 'user:delete', 'user:restore',

            // stats
            'stats:view',

            // post
            'post:viewAny', 'post:view', 'post:create', 'post:update', 'post:delete', 'post:restore',

            // news
            'news:viewAny', 'news:view', 'news:create', 'news:update', 'news:delete', 'news:restore',

            // chat
            'chat:viewAny', 'chat:view', 'chat:create', 'chat:update', 'chat:delete', 'chat:restore',

            // email
            'email:viewAny', 'email:view', 'email:create', 'email:update', 'email:delete', 'email:restore',

            // shop
            'order:viewAny', 'order:view', 'order:create', 'order:update', 'order:delete', 'order:restore',
            'product:viewAny', 'product:view', 'product:create', 'product:update', 'product:delete', 'product:restore',
            'stock:viewAny', 'stock:view', 'stock:create', 'stock:update', 'stock:delete', 'stock:restore',
            'category:viewAny', 'category:view', 'category:create', 'category:update', 'category:delete', 'category:restore',
            'review:viewAny', 'review:view', 'review:create', 'review:update', 'review:delete', 'review:restore',
            'attribute:viewAny', 'attribute:view', 'attribute:create', 'attribute:update', 'attribute:delete', 'attribute:restore',
            'value:viewAny', 'value:view', 'value:create', 'value:update', 'value:delete', 'value:restore',

            // delivery
            'delivery-method:viewAny', 'delivery-method:view', 'delivery-method:switch', 'delivery-method:create', 'delivery-method:update', 'delivery-method:delete', 'delivery-method:restore',

            // payment
            'payment-type:viewAny', 'payment-type:view', 'payment-type:switch', 'payment-type:create', 'payment-type:update', 'payment-type:delete', 'payment-type:restore',

            // discount
            'discount:create',
        ];

        // Эҷод кардани permission-ҳо (такрор намешаванд)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ADMIN (SUPERADMIN) → ҳамаи permission дорад
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        // EDITOR → танҳо барои post ва news
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'post:viewAny','post:view','post:create','post:update','post:delete','post:restore',
            'news:viewAny','news:view','news:create','news:update','news:delete','news:restore',
        ]);

        // HELPDESK → чат, email ва stats
        $helpdesk = Role::firstOrCreate(['name' => 'helpdesk-support']);
        $helpdesk->syncPermissions([
            'chat:viewAny','chat:view','chat:create','chat:update','chat:delete','chat:restore',
            'email:viewAny','email:view','email:create','email:update','email:delete','email:restore',
            'stats:view'
        ]);

        // SHOP MANAGER → идоракунии маҳсулот ва фармоишҳо
        $shop = Role::firstOrCreate(['name' => 'shop-manager']);
        $shop->syncPermissions([
            'order:viewAny','order:view','order:create','order:update','order:delete','order:restore',
            'product:viewAny','product:view','product:create','product:update','product:delete','product:restore',
            'stock:viewAny','stock:view','stock:create','stock:update','stock:delete','stock:restore',
            'category:viewAny','category:view','category:create','category:update','category:delete','category:restore',
            'review:viewAny','review:view','review:create','review:update','review:delete','review:restore',
            'attribute:viewAny','attribute:view','attribute:create','attribute:update','attribute:delete','attribute:restore',
            'value:viewAny','value:view','value:create','value:update','value:delete','value:restore',
            'delivery-method:viewAny','delivery-method:view','delivery-method:switch','delivery-method:create','delivery-method:update','delivery-method:delete','delivery-method:restore',
            'payment-type:viewAny','payment-type:view','payment-type:switch','payment-type:create','payment-type:update','payment-type:delete','payment-type:restore',
            'discount:create'
        ]);

        // CUSTOMER → корбари оддӣ
        Role::firstOrCreate(['name' => 'customer']);
    }
}
