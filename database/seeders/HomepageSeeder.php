<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageSetting;

class HomepageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['image' => 'pic1.jpg', 'text1' => 'Come join us', 'text2' => 'We have been waiting for you!', 'url' => ' '],
            ['image' => 'pic2.jpg', 'text1' => 'Don’t let men’s gifting give you the scaries!', 'text2' => 'We have been waiting for you!', 'url' => ' '],
            ['image' => 'pic3.jpg', 'text1' => 'Pamper yourself to curated suggestions', 'text2' => 'We have been waiting for you!', 'url' => ' '],
        ];

        foreach($settings as $setting){
            HomepageSetting::create($setting);
        }
    }
}
