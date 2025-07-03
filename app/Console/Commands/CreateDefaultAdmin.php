<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateDefaultAdmin extends Command
{
    protected $signature = 'create:default-admin';

    protected $description = 'Create default admin user from environment variables';

    public function handle()
    {
        $email = env('ADMIN_EMAIL');
        $name = env('ADMIN_NAME');
        $password = env('ADMIN_PASSWORD');

        if (User::where('email', $email)->exists()) {
            $this->info("Admin user already exists.");
            return;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info("Admin user created: $email");
    }
}
