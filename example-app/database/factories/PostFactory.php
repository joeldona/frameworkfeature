<?php

namespace Database\Factories;

use App\Models\Post; // 👈 Asegúrate de importar tu Modelo Post
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define el modelo asociado con esta Factory.
     */
    protected $model = Post::class; // 👈 Asegura que sabe que es para el Modelo Post

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Usamos fake() (Faker) para generar contenido de prueba
            'title' => fake()->sentence(8),       // Título: Una frase corta de hasta 8 palabras
            'content' => fake()->paragraphs(3, true), // Contenido: 3 párrafos de texto (como una cadena)
            
            // Marcas de tiempo (opcional, pero buena práctica)
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}