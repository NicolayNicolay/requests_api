<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Roles\Models\Role;
use Modules\Users\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::query()->create(
            [
                'name'     => 'admin',
                'email'    => 'admin@admin.ru',
                'password' => Hash::make('password'),
            ]
        );
        $role = Role::where('name', 'admin')->value('id');
        if (! empty($user) && ! empty($role)) {
            $user->addRole($role);
        }
    }
}
