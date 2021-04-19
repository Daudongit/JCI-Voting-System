<?php

use App\Slot;
use App\User;
use App\Voter;
use App\Result;
use App\Nominee;
use App\Election;
use App\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DBSeeder extends Seeder
{   
    protected $count = [
        'election'=>5,
        'position'=>10,
        'nominee'=>40,
        'voter'=>230,
        'slot'=>30,
        //'result'=>400
    ];

    protected $voters = null;
    protected $positions = null;
    protected $elections = null;
    protected $slots = null;
    protected $nominees = null;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->elections = factory(App\Election::class,$this->count['election'])->create();
        $this->positions = factory(App\Position::class,$this->count['position'])->create();
        $this->voters = factory(App\Voter::class,$this->count['voter'])->create();
        $this->slots = factory(App\Slot::class,$this->count['slot'])->create();
        $this->nominees = factory(App\Nominee::class,$this->count['nominee'])->create();
        $this->customFactory();
    }

    public function customFactory()
    {
        //$this->nominees();
        $this->results();
        $this->electionSlot();
        $this->nomineeSlot();
        $this->admin();
        //$this->electionPosition();
    }

    // private function nominees()
    // {
    //     $this->nominees = factory(App\Nominee::class,$this->count['nominee'])->create([
    //         'position_id'=>function(){
    //             return rand(1,$this->count['position']);
    //         }
    //     ]);
    // }

    private function results()
    {   
        $this->positions->each(function($position){
            $this->voters->each(function($voter)use($position){
                $electionId = rand(1,$this->count['election']);
                $signature = factory(App\Signature::class)->create([
                    'election_id'=>$electionId
                ]);
                return factory(App\Result::class)->create([
                    'voter_id'=>$voter->id,
                    'position_id'=>$position->id,
                    'nominee_id'=>function(){
                        return rand(1,$this->count['nominee']);
                    },
                    'election_id'=>$electionId,
                    'signature_id'=>$signature->id
                ]);
            });
        });
    }

    private function electionSlot()
    {   
        $election = 0;

        $this->slots->chunk(6)->each(function($slots)use(&$election){
            $election++;
            if($election <= $this->count['election'])
            {
                $slots->each(function($slot)use($election){
                    \DB::table('election_slot')->insert([
                        'election_id'=>$election,
                        'slot_id'=>$slot->id
                    ]);
                });
            }
        });
    }

    private  function nomineeSlot()
    {   
        $slot = 0;
        $this->nominees->chunk(5)->each(function($nominees)use(&$slot){
            $slot++;
            if($slot <= $this->count['slot'])
            {
                $nominees->each(function($nominee)use($slot){
                    \DB::table('nominee_slot')->insert([
                        'nominee_id'=>$nominee->id,
                        'slot_id'=>$slot
                    ]);
                });
            }
        });
    }
    // private function electionPosition()
    // {   
    //     $this->elections->each(function($election){
    //         $this->positions->each(function($position)use($election){
    //             \DB::table('election_position')->insert([
    //                 'position_id'=>$position->id,
    //                 'election_id'=>$election->id
    //             ]);
    //         });
    //     });
    // }

    private function admin()
    {
        User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.com',
            'password'=>bcrypt('password')
        ]);
    }
}
