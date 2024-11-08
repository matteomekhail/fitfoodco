<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignCustomMembership extends Command
{
    protected $signature = 'membership:assign-custom {email}';
    protected $description = 'Assign Custom15 membership to a specific user';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User not found with email: {$email}");
            return 1;
        }

        $user->membership = 'Custom15';
        $user->save();

        $this->info("Custom15 membership successfully assigned to {$email}");
        return 0;
    }
} 