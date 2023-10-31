<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class GenerateAdminAccount extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:generate {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!Schema::hasTable('users')) {
            $this->error('Users table is not available. Please run migration.');
            return;
        }

        $admin = User::where(['admin' => true])->first();

        if ($admin) {
            $this->info('Admin account is already available.');
            $this->line("Hint: username is {$admin->username}.");
            return;
        }

        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrator',
                'username' => $this->argument('username'),
                'email' => 'admin@example.com',
                'password' => $this->argument('password'),
                'admin' => true
            ]);

            $admin->markEmailAsVerified();
        }

        $this->line('Admin account is created.');
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'username' => 'Please enter a username.',
            'password' => 'Please enter a password.',
        ];
    }
}
