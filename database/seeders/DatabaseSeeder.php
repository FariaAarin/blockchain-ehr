<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create(
            
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'type' => 1,
            ],
        );

        \App\Models\User::create(

            [
                'id' => 2,
                'name' => 'Mohammad Khan',
                'email' => 'mohammadkhan@gmail.com',
                'password' => bcrypt('12345678'),
                'type' => 2,

            ]
        );
        \App\Models\User::create(

            [
                'id' => 3,
                'name' => 'Dr Alex',
                'email' => 'alex@gmail.com',
                'password' => bcrypt('12345678'),
                'type' => 2,
                
            ],
        );

        \App\Models\User::create(
            [
                'id' => 4,
                'uniqueId' => date('Y').rand ( 1000 , 9999),
                'name' => 'Robin',
                'email' => 'robin@gmail.com',
                'password' => bcrypt('12345678'),
                'type' => 3,
                
            ],
        );

        \App\Models\User::create(

            [
                'id' => 5,
                'uniqueId' => date('Y').rand ( 1000 , 9999),
                'name' => 'Farhan',
                'email' => 'farhan@gmail.com',
                'password' => bcrypt('12345678'),
                'type' => 3,
                
            ],
    
    
        );

        \App\Models\Pathology::create(

            [
                'id' => 1,
                'name' => 'X-Ray',
            ],
        );
        \App\Models\Pathology::create(

            [
                'id' => 2,
                'name' => 'CBC',
            ],

        );

        \App\Models\Pathology::create(

            [
                'id' => 3,
                'name' => 'RBS',
            ],
        );

        \App\Models\Pathology::create(

            [
                'id' => 4,
                'name' => 'ECG',
            ],
        );
    }
}
