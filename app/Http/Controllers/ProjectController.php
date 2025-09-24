<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class ProjectController extends Controller
{
    private $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    }

    /**
     * Display a listing of available projects.
     */
    public function index()
    {
        $projects = Project::where('status', 'published')
                          ->where('visibility', true)
                          ->with('category')
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Ensure project is visible and published
        if (!$project->visibility || $project->status !== 'published') {
            abort(404, 'Project not found.');
        }

        // Load related data
        $project->load('category');

        return view('projects.show', compact('project'));
    }

    /**
     * Initiate donation payment
     */
    public function initiateDonation(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'referral_volunteer_id' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        $project = Project::findOrFail($request->project_id);
        $user = Auth::user();

        // Create donation record
        $donation = Donation::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'project_name' => $project->title,
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_phone' => $request->donor_phone,
            'referral_volunteer_id' => $request->referral_volunteer_id,
            'amount' => $request->amount,
            'currency' => 'INR',
            'message' => $request->message,
            'is_anonymous' => $request->is_anonymous ?? false,
            'status' => 'pending',
        ]);

        try {
            // Create Razorpay order
            $orderData = [
                'receipt' => 'donation_' . $donation->id,
                'amount' => $request->amount * 100, // Amount in paise
                'currency' => 'INR',
                'notes' => [
                    'project_id' => $project->id,
                    'project_name' => $project->title,
                    'user_id' => $user->id,
                    'donation_id' => $donation->id,
                    'donor_name' => $request->donor_name,
                ]
            ];

            $order = $this->razorpay->order->create($orderData);

            // Update donation with order ID
            $donation->update([
                'razorpay_order_id' => $order['id'],
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'key' => env('RAZORPAY_KEY_ID'),
                'donation_id' => $donation->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay donation order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Donation initialization failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle donation payment callback
     */
    public function handleDonationCallback(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature' => 'required',
            'donation_id' => 'required|exists:donations,id',
        ]);

        $donation = Donation::findOrFail($request->donation_id);

        try {
            // Verify payment signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            // Update donation record
            $donation->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'completed',
                'payment_details' => $attributes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Donation successful! Thank you for your contribution.',
                'donation_id' => $donation->id,
                'redirect_url' => route('projects.donation-success', $donation->id),
                'close_modal' => true,
                'show_success' => true,
            ]);

        } catch (\Exception $e) {
            Log::error('Donation payment verification failed: ' . $e->getMessage());
            
            $donation->update(['status' => 'failed']);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed. Please contact support.',
                'close_modal' => false,
                'show_error' => true,
            ], 400);
        }
    }

    /**
     * Show donation success page
     */
    public function donationSuccess($donationId)
    {
        $donation = Donation::with(['project', 'user'])->findOrFail($donationId);
        
        if ($donation->status !== 'completed') {
            return redirect()->route('projects.index')->with('error', 'Invalid donation.');
        }

        return view('projects.donation-success', compact('donation'));
    }

    /**
     * Show user's donations
     */
    public function myDonations()
    {
        $donations = Donation::with(['project'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('projects.my-donations', compact('donations'));
    }
}