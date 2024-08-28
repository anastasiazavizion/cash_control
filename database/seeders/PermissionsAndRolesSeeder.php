<?php
namespace Database\Seeders;

use App\Enum\Permissions\Account;
use App\Enum\Permissions\Category;
use App\Enum\Permissions\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Enum\Role as RoleEnum;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ...Account::values(),
            ...Category::values(),
            ...User::values(),
        ];

        foreach ($permissions as $permission){
            Permission::findOrCreate($permission);
        }

        if(!Role::findByParam(['name'=>RoleEnum::CUSTOMER->value])){
            (Role::create(['name'=>RoleEnum::CUSTOMER->value]))
                ->givePermissionTo([...Account::values()]);
        }

        if(!Role::findByParam(['name'=>RoleEnum::ADMIN->value])){
            (Role::create(['name'=>RoleEnum::ADMIN->value]))->givePermissionTo($permissions);
        }

    }
}
