<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin 
                            {--email=admin@example.com : Email admin} 
                            {--password=password123 : Password admin} 
                            {--name=Admin : Nama admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat user admin untuk login ke Filament';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');

        // cek apakah user sudah ada
        if (User::where('email', $email)->exists()) {
            $this->error("User dengan email {$email} sudah ada!");
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("User admin berhasil dibuat!");
        $this->line("Email    : {$user->email}");
        $this->line("Password : {$password}");

        return 0;
    }
}
