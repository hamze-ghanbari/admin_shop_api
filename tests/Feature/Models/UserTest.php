<?php

namespace Tests\Feature\Models;

use App\Models\Role;
use App\Models\User;
use Database\Factories\RoleFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
//    use RefreshDatabase;

    public function test_get_users(){

    }

    public function test_user_create(): void
    {

//        Artisan::call('migrate');
       $user = User::factory()->make()->toArray();

      $userCreated = User::create($user);

//        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', $user);
        $this->assertModelExists($userCreated);
//        $this->assertTrue($user instanceof  User);
    }

    public function test_user_relation_with_role(){
        $user = Role::factory()->for(User::factory())->create();

        $this->assertTrue(isset($user->roles->id));
    }
}
