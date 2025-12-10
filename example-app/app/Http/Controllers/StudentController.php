<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course; // 👈 Importante: Necesitamos el modelo del Padre para los desplegables
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Usamos 'with' para optimizar la consulta (Eager Loading)
        $students = Student::with('course')->latest()->paginate(5);
        
        // compact: mete la variable $students en la "caja" para la vista
        return view('students.index', compact('students'));
    }

    public function create()
    {
        // Traemos todos los cursos para que el usuario elija en el desplegable
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'required|exists:courses,id', // Validamos que el curso exista
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Estudiante creado exitosamente.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            // Validamos email único pero ignorando el ID del estudiante actual
            'email' => 'required|email|unique:students,email,' . $student->id,
            'course_id' => 'required|exists:courses,id',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Estudiante actualizado exitosamente.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Estudiante eliminado exitosamente.');
    }

    // 👇 ESTE ES EL NUEVO MÉTODO QUE NECESITAS PARA EXPORTAR
    public function export()
    {
        $fileName = 'listado_estudiantes.csv';

        // 1. Traemos estudiantes CON su curso para no hacer 100 consultas (Eager Loading)
        $students = Student::with('course')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($students) {
            $file = fopen('php://output', 'w');

            // 2. Escribimos la cabecera del CSV
            fputcsv($file, ['ID', 'Nombre', 'Email', 'Curso Asignado', 'Fecha Registro']);

            // 3. Recorremos cada estudiante y escribimos su fila
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->id,
                    $student->name,
                    $student->email,
                    // Accedemos al nombre del curso a través de la relación
                    $student->course->name ?? 'Sin Curso', 
                    $student->created_at->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        // 4. Devolvemos la descarga directa
        return response()->stream($callback, 200, $headers);
    }
}