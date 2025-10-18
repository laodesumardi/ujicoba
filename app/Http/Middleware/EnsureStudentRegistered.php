<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentRegistered
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user is a student
        if ($user->role !== 'student') {
            return redirect()->route('login');
        }

        // Check if student has completed registration (has student_id and class_level)
        if (empty($user->student_id) || empty($user->class_level)) {
            // Redirect to registration form to complete registration
            return redirect()->route('register.form')
                ->with('warning', 'Silakan lengkapi data registrasi Anda terlebih dahulu.');
        }

        return $next($request);
    }
}