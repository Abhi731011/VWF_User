<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin_id' => 2,
        ]);

        event(new Registered($user));

        // Send registration notifications
        $emailResults = EmailService::sendRegistrationNotifications($user);

        Auth::login($user);

        // Prepare success message based on email results
        $successMessage = 'Registration successful! Welcome to Vaishvik Welfare Foundation.';
        
        if ($emailResults['user_email_sent']) {
            $successMessage .= ' A welcome email has been sent to your email address.';
        } else {
            $successMessage .= ' (Note: Welcome email could not be sent at this time.)';
        }

        return redirect(route('dashboard', absolute: false))
            ->with('success', $successMessage);
    }
}
