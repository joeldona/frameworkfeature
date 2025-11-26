<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post; // 👈 1. IMPORTANTE: Importar el Modelo Post

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Ejecutar la Factory
        Post::factory() // Llama a la fábrica asociada al modelo Post
            ->count(50) // Pide que cree 50 registros
            ->create(); // Ejecuta la creación e inserción en la DB
    }
}