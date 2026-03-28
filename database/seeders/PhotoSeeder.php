<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUserPhotos();
        $this->seedProductPhotos();
    }

    private function seedUserPhotos(): void
    {
        $source = base_path('assets/thumbnail.png');

        if (!File::exists($source)) {
            return;
        }

        foreach (User::take(8)->get() as $user) {
            $path = "users/{$user->id}/avatar.png";
            Storage::disk('public')->put($path, File::get($source));

            $user->photos()->create([
                'full_name' => "avatar-{$user->id}.png",
                'path' => $path,
            ]);
        }
    }

    private function seedProductPhotos(): void
    {
        $source = base_path('assets/ui.jpg');

        if (!File::exists($source)) {
            return;
        }

        foreach (Product::all() as $product) {
            $path = "products/{$product->id}/main.jpg";
            Storage::disk('public')->put($path, File::get($source));

            $product->photos()->create([
                'full_name' => "product-{$product->id}.jpg",
                'path' => $path,
            ]);
        }
    }
}
