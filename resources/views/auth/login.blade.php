@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="text-center text-primary">Login</h3>

        <form id="loginForm">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            let formData = {
                email: $('#email').val(),
                password: $('#password').val()
            };

            $.ajax({
                url: "/api/login",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(formData),
                success: function(response) {
                    localStorage.setItem('authToken', response.token);
                    Swal.fire("Success!", "Login successful!", "success").then(() => {
                        window.location.href = "/students";
                    });
                },
                error: function(xhr) {
                    Swal.fire("Error!", "Invalid credentials!", "error");
                }
            });
        });
    });
</script>
@endsection
