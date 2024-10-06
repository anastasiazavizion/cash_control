<?php
namespace Tests\Traits;

use App\Enum\Role;
use App\Models\User;
use Database\Seeders\PermissionsAndRolesSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Illuminate\Foundation\Testing\RefreshDatabase;

trait SetupTrait{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->seed(PermissionsAndRolesSeeder::class);
    }

    protected function afterRefreshingDatabase()
    {
        $this->seed(PermissionsAndRolesSeeder::class);
    }

    protected function user(Role $role = Role::ADMIN): User
    {
        return User::role($role->value)->firstOrFail();
    }

}
