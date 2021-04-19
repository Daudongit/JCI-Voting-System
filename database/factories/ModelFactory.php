<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Election::class,function(Faker\Generator $faker){
    $first_time = $faker->dateTimeBetween('-3 months');
    $second_time = $faker->dateTimeBetween('-3 months');
    
    return [
        'title'=>$faker->catchPhrase,
        'start'=>$first_time > $second_time?$second_time:$first_time,
        'end'=>$first_time > $second_time?$first_time:$second_time,
        'status'=>$faker->boolean
    ];
});

$factory->define(App\Position::class,function(Faker\Generator $faker){
    return [
        'name'=>$faker->unique()->word,
    ];
});

$factory->define(App\Nominee::class,function(Faker\Generator $faker){
    return [
        'first_name'=>$faker->firstName,
        'last_name'=>$faker->lastName,
        'email'=>$faker->unique()->safeEmail,
        'image'=>$faker->imageUrl(), 
        'description'=>$faker->sentence,
        // 'position_id'=>function(){
        //     return factory(App\Position::class)->create()->id;
        // },
    ];
});

$factory->define(App\Result::class,function(Faker\Generator $faker){
    return [
        'voter_id'=>function(){
            return factory(App\Voter::class)->create()->id;
        },
        'position_id'=>function(){
            return factory(App\Position::class)->create()->id;
        },
        'nominee_id'=>function(){
            return factory(App\Nominee::class)->create()->id;
        },
        'election_id'=>function(){
            return factory(App\Election::class)->create()->id;
        },
        'signature_id'=>function(){
            return factory(App\Signature::class)->create()->id;
        }
    ];
});

$factory->define(App\Voter::class,function(Faker\Generator $faker){
    return [
        'email'=>$faker->unique()->safeEmail,
        'ip'=>$faker->unique()->ipv4,
    ];
});

$factory->define(App\Slot::class,function(Faker\Generator $faker){
    return [
        'position_id'=>function(){
            return factory(App\Position::class)->create()->id;
        },
    ];
});

$factory->define(App\Signature::class,function(Faker\Generator $faker){
    return [
        'ip'=>$faker->unique()->ipv4,
        'election_id'=>function(){
            return factory(App\Election::class)->create()->id;
        },
        'browser_signature'=>$faker->word.''.time()
    ];
});