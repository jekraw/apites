<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Hash;

class HashPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwords:rehash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rehash passwords to bcrypt for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $users = DB::table('user')->get();
        foreach($users as $user) {
            DB::table('user')
            ->where('id', $user->id)
            ->update(['password' => Hash::make($user->password)]);
        }$this->info('All passwords have been rehashed.');

    }
}
