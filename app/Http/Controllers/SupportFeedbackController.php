<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportFeedbackController extends Controller
{
    /**
     * Display the support and feedback page.
     */
    public function index()
    {
        return view('support.index');
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
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|string|max:100',
        ]);

        // Here you would typically save to database
        // For now, we'll just redirect with success message
        
        return redirect()->route('support.index')
                        ->with('success', 'Your request has been submitted successfully! We will get back to you within 24-48 hours.');
    }
}
