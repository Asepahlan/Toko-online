<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserStatus extends Command
{
    protected $signature = 'users:update-status';
    protected $description = 'Update user active status based on their last activity';

    public function handle()
    {
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                $user->updateActiveStatus();
            }
        });

        $this->info('User status updated successfully');
    }
}
