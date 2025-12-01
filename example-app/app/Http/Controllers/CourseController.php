<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;


class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(5);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        // 1. CORRECCIÓN: Usamos 'name' y 'description' (según la migración)
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load('students');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        // 1. CORRECCIÓN: Campos correctos aquí también
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $course->update($request->all());

        // 2. CORRECCIÓN: La ruta es 'courses.index' (plural), no 'course.index'
        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        // 2. CORRECCIÓN: La ruta es 'courses.index' (plural)
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}