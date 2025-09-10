<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of available events for registration.
     */
    public function index()
    {
        $events = Event::all();
                    //   ->where('visibility', true)
                    //   ->where('registration_required', true)
                    //   ->where('event_date', '>=', now())
                    //   ->where(function($query) {
                        //   $query->whereNull('registration_deadline')
                                // ->orWhere('registration_deadline', '>=', now());
                      // })
                    //   ->with(['category', 'registrations' => function($query) {
                        //   $query->where('user_id', Auth::id());
                      // }])
                    //   ->orderBy('event_date')
                    //   ->paginate(12);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new registration.
     */
    public function create(Event $event)
    {
        // Check if user is already registered
        if ($event->isUserRegistered(Auth::id())) {
            return redirect()->route('events.index')
                           ->with('error', 'You are already registered for this event.');
        }

        // Check if registration is still open
        if ($event->registration_deadline && $event->registration_deadline < now()) {
            return redirect()->route('events.index')
                           ->with('error', 'Registration deadline has passed for this event.');
        }

        // Check if event is full
        if ($event->max_attendees && $event->registrations()->where('status', '!=', 'cancelled')->count() >= $event->max_attendees) {
            return redirect()->route('events.index')
                           ->with('error', 'This event is full.');
        }

        return view('events.register', compact('event'));
    }

    /**
     * Store a newly created registration.
     */
    public function store(Request $request, Event $event)
    {
        // Check if user is already registered
        if ($event->isUserRegistered(Auth::id())) {
            return redirect()->route('events.index')
                           ->with('error', 'You are already registered for this event.');
        }

        // Check if registration is still open
        if ($event->registration_deadline && $event->registration_deadline < now()) {
            return redirect()->route('events.index')
                           ->with('error', 'Registration deadline has passed for this event.');
        }

        // Check if event is full
        if ($event->max_attendees && $event->registrations()->where('status', '!=', 'cancelled')->count() >= $event->max_attendees) {
            return redirect()->route('events.index')
                           ->with('error', 'This event is full.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'special_requirements' => 'nullable|string|max:1000',
            'motivation' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['event_id'] = $event->id;
        $validated['registered_at'] = now();

        EventRegistration::create($validated);

        return redirect()->route('events.index')
                        ->with('success', 'Registration submitted successfully! You will be notified once your registration is reviewed.');
    }

    /**
     * Display the specified registration.
     */
    public function show(EventRegistration $eventRegistration)
    {
        // Ensure user can only view their own registrations
        if ($eventRegistration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('events.registration-details', compact('eventRegistration'));
    }

    /**
     * Show user's registrations.
     */
    public function myRegistrations()
    {
        $registrations = EventRegistration::where('user_id', Auth::id())
                                        ->with(['event', 'event.category'])
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(10);

        return view('events.my-registrations', compact('registrations'));
    }

    /**
     * Cancel a registration.
     */
    public function cancel(EventRegistration $eventRegistration)
    {
        // Ensure user can only cancel their own registrations
        if ($eventRegistration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow cancellation if status is pending or approved
        if (!in_array($eventRegistration->status, ['pending', 'approved'])) {
            return redirect()->route('events.my-registrations')
                           ->with('error', 'This registration cannot be cancelled.');
        }

        $eventRegistration->update(['status' => 'cancelled']);

        return redirect()->route('events.my-registrations')
                        ->with('success', 'Registration cancelled successfully.');
    }
}
