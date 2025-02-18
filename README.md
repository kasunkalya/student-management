Laravel 11 Student Management API

This is a Laravel 11 project for managing students and their course enrollments using an API-based approach.

Prerequisites

Before setting up the project, ensure you have the following installed:

PHP 8.2+

Composer

MySQL or any supported database

Node.js & npm (for frontend dependencies, if applicable)

Laravel dependencies (installed via Composer)

Setup & Installation

1. Clone the Repository

    git clone https://github.com/your-repo/student-management.git
    cd student-management

2. Install Dependencies

    composer install

3. Set Up Environment Variables

    Copy the .env.example file to .env:

    cp .env.example .env

Then, open .env and update database credentials:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_db_user
    DB_PASSWORD=your_db_password

4. Generate Application Key

    php artisan key:generate

5. Run Migrations & Seed Database

    php artisan migrate --seed

6. Start the Laravel Development Server

    php artisan serve

API Endpoints

Method

Endpoint

Description

GET

/api/students

Get all students

POST

/api/students

Create a student

PUT

/api/students/{id}

Update a student

DELETE

/api/students/{id}

Delete a student

Handling CSRF & Authentication

CSRF Protection Disabled for API: The VerifyCsrfToken middleware excludes API routes.

Authentication: If you require authentication, configure Laravel Sanctum.