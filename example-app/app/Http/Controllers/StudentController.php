<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course; // 👈 IMPORTANTE: Necesitamos el modelo del Padre
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Usamos 'with' ara optimizar la consulta y traer el curso asociado de golpe
        $students = Student::with('course')->latest()->paginate(5);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        // ➡️ PASO CLAVE: Traer todos los cursos para el desplegable
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
        // ➡️ PASO CLAVE: Traer cursos para que pueda cambiar de curso si quiere
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
}