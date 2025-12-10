<?php



namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Course extends Model
{
    use HasFactory; // Necesario para crear datos falsos luego

    // 👇 ESTO ES OBLIGATORIO para arreglar el error MassAssignmentException
    protected $fillable = ['name', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    
    public function export()
    {
        // 1. Nombre del archivo que se descargará
        $fileName = 'cursos_con_estudiantes.csv';

        // 2. Traemos los cursos CON los estudiantes (Eager Loading para optimizar)
        $courses = Course::with('students')->get();

        // 3. Cabeceras para las columnas del Excel/CSV
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        // 4. Creamos la función que escribe las líneas
        $callback = function() use($courses) {
            $file = fopen('php://output', 'w');

            // Escribimos la primera fila (Títulos de columnas)
            fputcsv($file, ['ID', 'Nombre del Curso', 'Descripción', 'Estudiantes Matriculados', 'Total Alumnos']);

            // Recorremos los cursos y escribimos una fila por cada uno
            foreach ($courses as $course) {
                
                // Truco: Convertimos la lista de estudiantes en un texto separado por comas
                // Ejemplo: "Juan, Pepe, María"
                $nombresEstudiantes = $course->students->pluck('name')->implode(', ');

                fputcsv($file, [
                    $course->id,
                    $course->name,
                    $course->description,
                    $nombresEstudiantes, // Aquí va la lista de nombres
                    $course->students->count() // Aquí el número total
                ]);
            }

            fclose($file);
        };

        // 5. Devolvemos la descarga
        return response()->stream($callback, 200, $headers);
    }
}
// Añade esto dentro de la clase
