<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDefaultAdmin extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Create or update the default admin user';

    public function handle()
    {
        $adminRole = Role::where('name', 'admin')->first();

        if (! $adminRole) {
            $this->error('Admin role not found!');

            return 1;
        }

        $admin = User::updateOrCreate(
            ['email' => 'syntraprogrammeurs@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $admin->roles()->sync([$adminRole->id]);

        $this->info('Default admin user updated successfully!');
        $this->info('Email: syntraprogrammeurs@gmail.com');
        $this->info('Password: 12345678');
    }
}
