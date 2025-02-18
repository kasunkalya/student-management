@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <h2 class="text-primary">Add New Student</h2>

    <form id="addStudentForm" class="p-3 bg-light rounded">
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Courses:</label>
            <select name="courses[]" id="courses" class="form-select" multiple required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#addStudentForm').on('submit', function(e) {
            e.preventDefault();

            let formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                courses: $('#courses').val(),
            };

            $.ajax({
                url: "/api/students",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(formData),
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('authToken'),  // Ensure the token is set
                    "Accept": "application/json",
                },
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: "Student added successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "{{ route('students.index') }}"; 
                    });
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors || {};
                    let errorMessage = Object.values(errors).map(err => err[0]).join("\n");

                    Swal.fire({
                        title: "Error!",
                        text: errorMessage || "Something went wrong!",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    });
</script>
@endsection
