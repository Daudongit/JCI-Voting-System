<?php

use App\User;
use App\Nominee;
use App\Position;
use Illuminate\Database\Seeder;

class DbRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = collect(DbRealData::$datas);

        $this->positions = $datas->keys();

        $this->nominees = $datas->values();

        $this->positions();

        $this->nominees();

        $this->admin();
    }

    private function nominees()
    {
        $this->nominees->each(function($nominee){
            collect($nominee)->each(function($nomineeItem){
                $name = $this->getName($nomineeItem['name']);
                factory(App\Nominee::class)->create([
                    'first_name'=>$name['first_name'],
                    'last_name'=>$name['last_name'],
                    'description'=>$nomineeItem['desc'],
                    'image'=>null
                ]);
            });
        });
    }

    private function positions()
    {
        $this->positions->each(function($position){
            factory(App\Position::class)->create([
                "name"=>$position
            ]);
        });
    }
    
    private function getName($name)
    {
        $names = explode(' ',$name);
        $return['first_name'] = $names[0];
        
        $return['last_name'] = count($names)>2?
            implode(' ',array_slice($names,1)):$names[1];

        return $return;
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
