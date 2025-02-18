<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;

class StudentController extends Controller
{
 
    public function index(Request $request)
    {
        $query = Student::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
        }
    
        $students = $query->with('courses')->get();
    
        if ($request->ajax()) {
            return response()->json(['students' => $students]);
        }
    
        return view('students.index', compact('students'));
    }
    

        public function studentList()
        {
            $students = Student::all();
            return response()->json($students);
        }


    
        public function show($id)
        {
            $student = Student::find($id);
            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }
            return response()->json($student, 200);
        }

        public function create()
        {
            $courses = Course::all();
            return view('students.create', compact('courses'));
        }
    
    
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'courses' => 'array', 
                'courses.*' => 'exists:courses,id',
            ]);
        
            $student = Student::create($request->only(['name', 'email']));
        
          
            if ($request->has('courses')) {
                $student->courses()->attach($request->courses);
            }
        
            return response()->json([
                'student' => $student,
                'courses' => $student->courses()->get()
            ], 201);
        }

        public function edit($id)
        {
            $student = Student::findOrFail($id);
            $courses = Course::all();
            return view('students.edit', compact('student', 'courses'));
        }

    
        public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $id,
                'courses' => 'array',
                'courses.*' => 'exists:courses,id',
            ]);
    
            $student = Student::findOrFail($id);
            $student->update($request->only(['name', 'email']));    

            $student->courses()->sync($request->courses ?? []);
    
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        }
    
        public function destroy($id)
        {
            $student = Student::find($id);
            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }
    
            $student->delete();
            return response()->json(['message' => 'Student deleted successfully'], 200);
        }
}
