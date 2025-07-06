<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(15)->create();


        $filename = 'user_photo' . '.png';
        $sourceDummy = public_path('dummy/user_photos/' . rand(1, 6) . '.png'); // ambil random
        $storagePath = 'user_photos/' . $filename;
        Storage::disk('public')->put($storagePath, file_get_contents($sourceDummy));

        User::create([
            'name'              => 'User',
            'email'             => 'user@example.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),  
            'remember_token'    => Str::random(10),
            'photo_path'        => 'user_photos/' . $filename    
        ]);
    }
}