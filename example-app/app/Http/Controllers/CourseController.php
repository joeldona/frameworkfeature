<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        // Usamos latest() para ver los últimos primero y paginamos de 5 en 5
        $courses = Course::latest()->paginate(5);
        
        // compact: mete la variable $courses en la "caja" para la vista
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    public function show(Course $course)
    {
        // Carga Ansiosa Diferida: Traemos los estudiantes de este curso
        $course->load('students');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Curso eliminado exitosamente.');
    }

    // 👇 MÉTODO DE EXPORTACIÓN (CSV NATIVO)
    public function export()
    {
        $fileName = 'listado_cursos.csv';

        // 1. Traemos cursos CON estudiantes (Eager Loading)
        $courses = Course::with('students')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($courses) {
            $file = fopen('php://output', 'w');

            // 2. Cabeceras del CSV
            fputcsv($file, ['ID', 'Nombre del Curso', 'Descripción', 'Estudiantes Matriculados', 'Total Alumnos']);

            // 3. Recorremos los cursos
            foreach ($courses as $course) {
                
                // Truco: Convertimos la lista de estudiantes en un texto: "Juan, Pepe, María"
                $nombresEstudiantes = $course->students->pluck('name')->implode(', ');

                fputcsv($file, [
                    $course->id,
                    $course->name,
                    $course->description,
                    $nombresEstudiantes, // Lista de nombres en una celda
                    $course->students->count() // Cantidad total
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}