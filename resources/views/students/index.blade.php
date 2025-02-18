@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <h2 class="text-primary">Students</h2>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" id="createStudentBtn">Add New Student</button>
        <input type="text" id="search" class="form-control w-50" placeholder="Search by name or email...">
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Courses</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="studentTableBody">
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->courses->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <button class="btn btn-sm btn-danger deleteStudent" data-id="{{ $student->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('students.index') }}",
                type: "GET",
                data: { search: query },
                success: function(response) {
                    let rows = '';
                    response.students.forEach(student => {
                        let courses = student.courses.map(course => course.name).join(', ');

                        rows += `
                            <tr>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>${courses}</td>
                                <td>
                                    <a href="/students/${student.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    <button class="btn btn-sm btn-danger deleteStudent" data-id="${student.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });

                    $('#studentTableBody').html(rows);
                }
            });
        });

        $(document).on('click', '.deleteStudent', function() {
            let studentId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This student will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `api/students/${studentId}`,
                        type: "POST",
                        data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                        headers: {
                            "Authorization": "Bearer " + localStorage.getItem('authToken'),  // Ensure the token is set
                            "Accept": "application/json",
                        },
                        success: function() {
                            Swal.fire("Deleted!", "Student has been removed.", "success");
                            $(`button[data-id="${studentId}"]`).closest('tr').remove();
                        }
                    });
                }
            });
        });

        $('#createStudentBtn').click(function() {
            window.location.href = "{{ route('students.create') }}";
        });
    });
</script>
@endsection
