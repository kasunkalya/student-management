@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <h2 class="text-primary">Edit Student</h2>

    <form id="editStudentForm" class="p-3 bg-light rounded">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" id="name" value="{{ $student->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" id="email" value="{{ $student->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Courses:</label>
            <select name="courses[]" id="courses" class="form-select" multiple required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" 
                        @if($student->courses->contains($course->id)) selected @endif>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#editStudentForm').on('submit', function(e) {
            e.preventDefault();

            let studentId = {{ $student->id }};
            let formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                courses: $('#courses').val()
            };

            $.ajax({
                url: "/api/students/" + studentId, 
                type: "PUT",
                contentType: "application/json",
                data: JSON.stringify(formData),
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem('authToken'),
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: "Student updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "/students"; 
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
