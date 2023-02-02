<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Plank\Mediable\Facades\MediaUploader;
use Storage;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pictures = ['1.jpg', '2.jpg', '3.jpg'];

//        foreach ($pictures as $picture) {
//            $url = env('APP_URL') . Storage::url("avatars/$picture");
//            MediaUploader::fromSource($url)->upload();
//        }
    }
}
