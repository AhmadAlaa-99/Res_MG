<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Hash;
use Faker\Factory;
use App\Models\Table;
use App\Models\User;
use App\Models\Customer;
use App\Models\Cuisine;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\Resturant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker=Factory::create();
        // \App\Models\User::factory(10)->create();
  //Admin
        \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@admin.com',
            'password' => bcrypt('12345678'),
            'role_name'=>'admin',
            'phone'=>'963432422',
            'status'=>'مفعل'
        ]);
         //cuisine 
         $cuisine_types=['عربي','غربي','فرنسي','الماني'];
         for($i=0; $i<4 ;$i++)
         {
              Cuisine::create([
              'name'=>$cuisine_types[array_rand($cuisine_types)],
         ]);
        }
          //Staff 
          for($i=0; $i<10 ;$i++)
          {
              \App\Models\User::create([
                'name' =>$faker->name,
                'email' => $faker->email,
                'password' => bcrypt('12345678'),
                'role_name'=>'staff',
                'phone'=>'9639'.random_int(10000000,99999999),
                'status'=>'مفعل',
              ]);
          }
        //Resturant
        for($i=2; $i<12 ;$i++)
        {
            \App\Models\Resturant::create([
              'user_id' =>$i,
              'cuisine_id' => random_int(1,4),
              'description' => $faker->paragraph,
              'location'=>'damascus',
              'name'=>$faker->name,
            //  'Activation_time'=>'2023-09-10 | 2023-09-20',
            'Activation_start'=>'2023-09-10',
            'Activation_end'=>'2023-09-27',
              'phone_number'=>'9639'.random_int(10000000,99999999),
            ]);
        }
         //menus
         $name=['بطاطا','بيض','فلافل','كباب'];
         for($i=0; $i<30 ;$i++)
         {
             \App\Models\Menu::create([
               'resturant_id'=>random_int(1,8),
               'name' =>array_rand($name),
               'price' =>'10000',
             ]);
         }
         for($i=0; $i<30 ;$i++)
         {
            //11--41
            //Customers
            \App\Models\Customer::create([
            'name' =>$faker->name,
            'email' => $faker->email,
            'password' => bcrypt('12345678'),           
            'phone'=>'963432422',
      
        ]);      }
        //tables
        $config_seat=['فردي','زوجي','رباعي'];
        for($i=0; $i<10 ;$i++)
        {
              \App\Models\Table::create([
             'number' =>random_int(100,999),
             'resturant_id' =>'2',
             'seating_configuration' => array_rand($config_seat),
             'capacity'=>'4',]);  
            }
            /*
        $times=['9:15','9:30','9:45','10:00','11:15'];
        for($i=0; $i<4 ;$i++)
        {
             \App\Models\Reservation::create([
             'customer_id' =>$i+=1,
             'table_id' =>'1',
             'resturant_id' =>'2',
             'speacial_request'=>'fdsfsd fsFSD',
             'reservation_time' => $times[$i],
             'party_size'=>'5',
             'status'=>'next',
            ]);  
          }
        $times=['12:00','12:30','12:45','01:00','01:15'];
        for($i=0; $i<5 ;$i++)
        {
         // $user_id='11';
             \App\Models\Reservation::create([
            // 'user_id' =>$user_id+=1,
             'table_id' =>'1',
             'resturant_id' =>'2',
            // 'speacial_request'=>'fdsfsd fsFSD',
             'reservation_time' => $times[$i],
            // 'party_size'=>'5',
             'status'=>'scheduled',
            ]);  
          //   $user_id+=1;
        }
        */
        //reviews
        //images 
    }
}
