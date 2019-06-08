<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        if ($this->command->confirm('Do you wish to  seed real data')) {
            
            $this->call(DbRealSeeder::class);

            $this->command->info('Real data successfully seeded!');
        }else{

            $this->call(DBSeeder::class);

            $this->command->info('Dummy data successfully seeded!');
        }
        //$this->admin();
    }

    private function admin()
    {
        User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.com',
            'password'=>bcrypt('password')
        ]);
    }
}
