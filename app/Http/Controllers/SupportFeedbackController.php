<?php

namespace App\Http\Controllers;

use App\Models\SupportFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportFeedbackController extends Controller
{
    /**
     * Display the support and feedback page.
     */
    public function index()
    {
        $supportRequests = Auth::user()->supportFeedback()->latest()->paginate(10);
        return view('support.index', compact('supportRequests'));
    }

    /**
     * Store a new support request or feedback.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:support,feedback,bug_report,feature_request',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'priority' => 'required|in:low,medium,high',
            'category' => 'required|string|max:100',
        ]);

        // Add user_id to validated data
        $validated['user_id'] = Auth::id();

        // Create the support feedback record
        SupportFeedback::create($validated);
        
        return redirect()->route('support.index')
                        ->with('success', 'Your request has been submitted successfully! We will get back to you within 24-48 hours.');
    }

    /**
     * Display the specified support request.
     */
    public function show(SupportFeedback $supportFeedback)
    {
        // Ensure the user can only view their own support requests
        if ($supportFeedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('support.show', compact('supportFeedback'));
    }
}
