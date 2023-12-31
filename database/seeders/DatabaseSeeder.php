<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\images_offer;
use Faker\Factory;
use App\Models\Table;
use App\Models\User;
use App\Models\Customer;
use App\Models\Cuisine;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\offer;
use App\Models\Resturant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call(PermissionSeeder::class);
      // $this->call(CreateAdminSeeder::class);

        $faker=Factory::create();
        // \App\Models\User::factory(10)->create();
        //Admin
        \App\Models\User::create([
            'name' => 'HDR ADMIN',
            'email' => 'HDR@gmail.com',
            'password' => bcrypt('Hdr@2132'),
            'role_name'=>'admin',
            'phone'=>'09'.random_int(11111111,99999999),
            'status'=>'active'
        ]);
        $user=User::latest()->first();
        $role = Role::where('name','admin')->first();
        $user->assignRole([$role->id]);
        //cuisine 
        $cuisine_types=['عربي','غربي','فرنسي','الماني'];
         for($i=0; $i<4 ;$i++)
         {
              Cuisine::create([
              'name'=>$cuisine_types[array_rand($cuisine_types)],
              'desc'=>'details test'
         ]);
        }
          //Staff 
          $role = Role::where('name','staff')->first();
          for($i=0; $i<10 ;$i++)
          {
            $userData = [
              'name' => $faker->name,
              'password' => bcrypt('Hdr@2132'),
              'role_name' => 'staff',
              'phone' => '09' . random_int(11111111, 99999999),
              'status' => 'active',
          
          ];
      
          if ($i === 1) {
              $userData['email'] = 'HDR_staff@gmail.com';
          } else {
              $userData['email'] = $faker->email;
          }
      
          \App\Models\User::create($userData);
         
       
          $user->assignRole([$role->id]);
          }
      
        //Resturant
        $k=1;
        $start=['Damascus','Homs','Lattakia','Aleppo','Tartus','As-suwayda'];
        $m=1;
        for($i=2; $i<12 ;$i++)
        {
            \App\Models\Resturant::create([
              'user_id' =>$i,
              'cuisine_id' => random_int(1,4),
              'description' => $faker->paragraph,
              'name'=>$faker->name,
            //  'Activation_time'=>'2023-09-10 | 2023-09-20',
             'Activation_start'=>'2023-09-10',
             'Activation_end'=>'2023-09-27',
              'phone_number'=>'9639'.random_int(10000000,99999999),
              'age_range'=>serialize(['start_age' =>18,'end_age' => 30]),
              'services'=>json_encode(['wifi' =>'attachments\\resturants\\images\\wifi.png','call' =>'attachments\\resturants\\images\\wifi.png']),
              'Deposite_information'=>'(50,$50 deposite per persone is required)',
              'refund_policy'=>('24,refund until 1 day'),
              'change_policy'=>('3,booking change until 3 hours'),
              'cancellition_policy'=>('4,cancellation allowed until 4 hours'),
            ]);
            $resturant=Resturant::latest()->first();
            \App\Models\Image::create([
              'filename'=>'attachments\resturants\images\test_image.jpg',
              'imageable_id'=>$k,
              'type' => 'main',
              'imageable_type'=>'App\Models\Resturant',
            ]);
            \App\Models\Image::create([
              'filename'=>'attachments\resturants\images\test_logo.jpg',
              'imageable_id'=>$k,
              'type' => 'logo',
              'imageable_type'=>'App\Models\Resturant',
            ]);
            $randomStartIndex = array_rand($start); 
            $randomStart = $start[$randomStartIndex]; 
            \App\Models\Location::create([
               'resturant_id'=>$k,
               'latitude'=>'0',
               'longitude'=>'0',
               'state'=>$randomStart,
               'text'=>'details location',
            ]);
            $k+=1;
        }
         //menus
         $menus=['pizza','eggs','kabab','laemon'];
         for($i=0; $i<30 ;$i++)
         {
          $randomMenuIndex = array_rand($menus); 
          $randomMenu = $start[$randomMenuIndex]; 
             \App\Models\Menu::create([
               'resturant_id'=>random_int(1,8),
               'name' =>$randomMenu,
               'price' =>'10000',
             ]);
         }
         for($i=0; $i<30 ;$i++)
         {
            //11--41
            //Customers

            \App\Models\Customer::create([
            'firstname' =>$faker->name,
            'lastname' =>$faker->name,
            'gender' =>'male',
            'State' =>'Damas',
            'email' => $faker->email,
            'password' => bcrypt('Hdr@2132'),           
            'phone'=>'09'.random_int(11111111,99999999),
            'birth_date'=>'1999/10/10',
      
        ]);  
      }
        //tables
        $config_seat=['فردي','زوجي','رباعي'];
        $type=['offer','new_opening'];
        

        for($i=0; $i<10 ;$i++)
        {
              \App\Models\Table::create([
             'number' =>random_int(100,999),
             'resturant_id' =>'2',
             'seating_configuration' =>$config_seat[array_rand($config_seat)],
             'capacity'=>'4',]);  
            }
            $h=1;
            for($i=0; $i<5 ;$i++)
            {
              
            offer::create([
              'price_old'=>'20000',
              'price_new'=>'19999',
              'desc'=>'test offer',
              'name'=>'name offer',
              'type'=>$type[array_rand($type)],
              'open_year'=>'2020/10/10',
              'featured'=>['wifi','water'],
              'resturant_id'=>'1'
              ]);
              $offer=offer::latest()->first();
               images_offer::create([
                'filename'=>'attachments\resturants\images\test_image.jpg',
                'imageable_id'=>$h,
                'type'=>'cover',
                'imageable_type'=>'App\Models\offer',
              ]);
              images_offer::create([
                'filename'=>'attachments\resturants\images\test_image.jpg',
                'imageable_id'=>$h,
                'type'=>'main',
                'imageable_type'=>'App\Models\offer',
              ]);
              images_offer::create([
                'filename'=>'attachments\resturants\images\test_image.jpg',
                'imageable_id'=>$h,
                'type'=>'others',
                'imageable_type'=>'App\Models\offer',
              ]);
              $h+=1;
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
        $icons = [
         
          ['name' => 'Icon 1', 'image' => 'attachments\resturants\images\wifi.png'],
          ['name' => 'Icon 2', 'image' => 'attachments\resturants\images\wifi.png'],
      ];
      foreach ($icons as $icon) {
          DB::table('icons')->insert([
              'name' => $icon['name'],
              'image' => $icon['image'],
          ]);
      }
    }
}
