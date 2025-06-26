<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plakat;

class PlakatSeeder extends Seeder
{
    public function run(): void
    {
        $plakats = [
            [
                'nama' => 'Plakat Kayu Premium',
                'deskripsi' => 'Plakat kayu berkualitas tinggi dengan finishing glossy. Cocok untuk penghargaan dan apresiasi.',
                'harga' => 150000,
                'gambar' => 'plakats/plakat-kayu-1.jpg',
                'kategori' => 'Kayu',
                'status' => true,
            ],
            [
                'nama' => 'Plakat Akrilik Transparan',
                'deskripsi' => 'Plakat akrilik transparan dengan gravir laser. Desain modern dan elegan.',
                'harga' => 200000,
                'gambar' => 'plakats/plakat-akrilik-1.jpg',
                'kategori' => 'Akrilik',
                'status' => true,
            ],
            [
                'nama' => 'Plakat Logam Stainless',
                'deskripsi' => 'Plakat logam stainless steel dengan engraving presisi. Tahan lama dan berkelas.',
                'harga' => 300000,
                'gambar' => 'plakats/plakat-logam-1.jpg',
                'kategori' => 'Logam',
                'status' => true,
            ],
            [
                'nama' => 'Plakat Kristal Premium',
                'deskripsi' => 'Plakat kristal premium dengan laser engraving 3D. Sangat mewah dan eksklusif.',
                'harga' => 500000,
                'gambar' => 'plakats/plakat-kristal-1.jpg',
                'kategori' => 'Kristal',
                'status' => true,
            ],
            [
                'nama' => 'Plakat Kayu Jati',
                'deskripsi' => 'Plakat kayu jati asli dengan ukiran tradisional. Cocok untuk acara formal.',
                'harga' => 250000,
                'gambar' => 'plakats/plakat-kayu-2.jpg',
                'kategori' => 'Kayu',
                'status' => true,
            ],
            [
                'nama' => 'Plakat Akrilik Warna',
                'deskripsi' => 'Plakat akrilik berwarna dengan cutting laser. Tersedia berbagai pilihan warna.',
                'harga' => 180000,
                'gambar' => 'plakats/plakat-akrilik-2.jpg',
                'kategori' => 'Akrilik',
                'status' => true,
            ],
            [
                'nama' => 'Trophy Logam Emas',
                'deskripsi' => 'Trophy logam dengan finishing emas. Cocok untuk kompetisi dan lomba.',
                'harga' => 350000,
                'gambar' => 'plakats/trophy-logam-1.jpg',
                'kategori' => 'Trophy',
                'status' => true,
            ],
            [
                'nama' => 'Plakat Marmer Hitam',
                'deskripsi' => 'Plakat marmer hitam dengan gravir emas. Sangat elegan dan mewah.',
                'harga' => 400000,
                'gambar' => 'plakats/plakat-marmer-1.jpg',
                'kategori' => 'Marmer',
                'status' => true,
            ],
        ];

        foreach ($plakats as $plakat) {
            Plakat::create($plakat);
        }
    }
}