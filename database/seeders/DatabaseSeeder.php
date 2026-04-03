<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        [
            'name' => 'Admin Name',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'nid' => '723453389',
            'license' => null,
            'phone' => '0166865596',
            'status' => '1',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'name' => 'Officer Name 1',
            'role' => 'officer',
            'email' => 'officer1@gmail.com',
            'nid' => '123456789',
            'license' => null,
            'phone' => '0156865597',
            'status' => '0',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'name' => 'Officer Name 2',
            'role' => 'officer',
            'email' => 'officer2@gmail.com',
            'nid' => '987654321',
            'license' => null,
            'phone' => '0156865598',
            'status' => '0',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'name' => 'Officer Name 3',
            'role' => 'officer',
            'email' => 'officer3@gmail.com',
            'nid' => '111111111',
            'license' => null,
            'phone' => '0150865599',
            'status' => '0',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        
        [
            'name' => 'Officer Name 4',
            'role' => 'officer',
            'email' => 'officer4@gmail.com',
            'nid' => '222222222',
            'license' => null,
            'phone' => '0151265599',
            'status' => '0',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'name' => 'User Name 1',
            'role' => 'user',
            'email' => 'user1@gmail.com',
            'nid' => '456789123',
            'license' => '123456789',
            'phone' => '0156865600',
            'status' => '0',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'name' => 'User Name 2',
            'role' => 'user',
            'email' => 'user2@gmail.com',
            'nid' => '321654987',
            'license' => '987654321',
            'phone' => '0156865601',
            'status' => '0',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
    ]);

        $data = [];

        $bangladesh = [

            'Dhaka' => [
                'Dhaka' => ['Dhanmondi', 'Mirpur'],
                'Gazipur' => ['Tongi', 'Sreepur'],
                'Narsingdi' => ['Belabo', 'Monohardi'],
                'Kishoreganj' => ['Bhairab', 'Katiadi'],
                'Manikganj' => ['Singair', 'Saturia'],
                'Munshiganj' => ['Sreenagar', 'Tongibari'],
                'Narayanganj' => ['Sonargaon', 'Rupganj'],
                'Tangail' => ['Ghatail', 'Mirzapur'],
                'Faridpur' => ['Boalmari', 'Nagarkanda'],
                'Gopalganj' => ['Kashiani', 'Tungipara'],
                'Madaripur' => ['Shibchar', 'Kalkini'],
                'Rajbari' => ['Pangsha', 'Baliakandi'],
                'Shariatpur' => ['Naria', 'Zajira'],
            ],

            'Chittagong' => [
                'Chittagong' => ['Pahartali', 'Kotwali'],
                'Coxsbazar' => ['Moheshkhali', 'Teknaf'],
                'Bandarban' => ['Thanchi', 'Ruma'],
                'Rangamati' => ['Baghaichari', 'Kaptai'],
                'Khagrachari' => ['Dighinala', 'Panchari'],
                'Comilla' => ['Daudkandi', 'Debidwar'],
                'Feni' => ['Chhagalnaiya', 'Sonagazi'],
                'Brahmanbaria' => ['Ashuganj', 'Nasirnagar'],
                'Lakshmipur' => ['Raipur', 'Ramganj'],
                'Noakhali' => ['Begumganj', 'Companiganj'],
                'Chandpur' => ['Haimchar', 'Matlab'],
            ],

            'Rajshahi' => [
                'Rajshahi' => ['Boalia', 'Motihar'],
                'Natore' => ['Baraigram', 'Lalpur'],
                'Naogaon' => ['Sapahar', 'Manda'],
                'Chapainawabganj' => ['Shibganj', 'Nachole'],
                'Pabna' => ['Ishwardi', 'Bera'],
                'Bogura' => ['Shibganj', 'Kahaloo'],
                'Joypurhat' => ['Akkelpur', 'Kalai'],
                'Sirajganj' => ['Belkuchi', 'Kazipur'],
            ],

            'Khulna' => [
                'Khulna' => ['Sonadanga', 'Khalishpur'],
                'Bagerhat' => ['Mongla', 'Rampal'],
                'Satkhira' => ['Assasuni', 'Debhata'],
                'Jessore' => ['Jhikargacha', 'Bagherpara'],
                'Narail' => ['Kalia', 'Lohagara'],
                'Magura' => ['Sreepur', 'Mohammadpur'],
                'Jhenaidah' => ['Shailkupa', 'Kaliganj'],
                'Kushtia' => ['Kumarkhali', 'Bheramara'],
                'Chuadanga' => ['Alamdanga', 'Damurhuda'],
                'Meherpur' => ['Gangni', 'Mujibnagar'],
            ],

            'Barishal' => [
                'Barishal' => ['Bakerganj', 'Banaripara'],
                'Patuakhali' => ['Bauphal', 'Galachipa'],
                'Bhola' => ['Lalmohan', 'Charfesson'],
                'Pirojpur' => ['Nazirpur', 'Mathbaria'],
                'Jhalokathi' => ['Kathalia', 'Nalchity'],
                'Barguna' => ['Amtali', 'Patharghata'],
            ],

            'Sylhet' => [
                'Sylhet' => ['Beanibazar', 'Golapganj'],
                'Moulvibazar' => ['Sreemangal', 'Kulaura'],
                'Habiganj' => ['Madhabpur', 'Chunarughat'],
                'Sunamganj' => ['Tahirpur', 'Derai'],
            ],

            'Rangpur' => [
                'Rangpur' => ['Badarganj', 'Mithapukur'],
                'Dinajpur' => ['Birganj', 'Parbatipur'],
                'Kurigram' => ['Nageshwari', 'Ulipur'],
                'Gaibandha' => ['Gobindaganj', 'Sundarganj'],
                'Nilphamari' => ['Saidpur', 'Domar'],
                'Panchagarh' => ['Boda', 'Debiganj'],
                'Thakurgaon' => ['Pirganj', 'Ranisankail'],
                'Lalmonirhat' => ['Patgram', 'Kaliganj'],
            ],

            'Mymensingh' => [
                'Mymensingh' => ['Trishal', 'Muktagacha'],
                'Jamalpur' => ['Islampur', 'Melandah'],
                'Sherpur' => ['Nalitabari', 'Sreebardi'],
                'Netrokona' => ['Atpara', 'Barhatta'],
            ],

        ];

            $contactCounter = 500000000; // base number

            foreach ($bangladesh as $division => $districts) {
                foreach ($districts as $district => $thanas) {
                    foreach ($thanas as $thana) {
                        $data[] = [
                            'division' => $division,
                            'district' => $district,
                            'thana_name' => $thana,
                            'contact' => '01' . $contactCounter++, // unique
                            'address' => $thana,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }

            DB::table('thana')->insert($data);



            $thanas = DB::table('thana')->get();

            $areas = [];

            foreach ($thanas as $thana) {

                $areas[] = [
                    'district' => $thana->district,
                    'thana_name' => $thana->thana_name,
                    'area_name' => $thana->thana_name . ' Area 1',
                    'details_area' => $thana->thana_name . ' Details 1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                $areas[] = [
                    'district' => $thana->district,
                    'thana_name' => $thana->thana_name,
                    'area_name' => $thana->thana_name . ' Area 2',
                    'details_area' => $thana->thana_name . ' Details 2',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            DB::table('area')->insert($areas);

            

    }
}
