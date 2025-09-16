<?php

namespace App\Http\Controllers;

use App\Models\CertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CertificateRequestController extends Controller
{
    /**
     * Show the certificate request form.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Check if user is eligible (created more than 30 days ago)
        $isEligible = $user->created_at->diffInDays(Carbon::now()) >= 30;
        
        // Check if user already has a pending or approved request
        $existingRequest = CertificateRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
        
        return view('certificates.request', compact('isEligible', 'existingRequest'));
    }

    /**
     * Store a new certificate request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check eligibility again
        if ($user->created_at->diffInDays(Carbon::now()) < 30) {
            return response()->json([
                'success' => false,
                'message' => 'You are not eligible for certificate yet. You need to be registered for at least 30 days.'
            ], 400);
        }

        // Check if user already has a pending or approved request
        $existingRequest = CertificateRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
            
        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a certificate request pending or approved.'
            ], 400);
        }

        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'certificate_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/certificates'), $imageName);
            $imagePath = 'uploads/certificates/' . $imageName;
        }

        // Create certificate request
        $certificateRequest = CertificateRequest::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Certificate request submitted successfully! We will review your request and get back to you soon.'
        ]);
    }

    /**
     * Show user's certificate requests.
     */
    public function index()
    {
        $user = Auth::user();
        $requests = CertificateRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('certificates.index', compact('requests'));
    }

    /**
     * Show a specific certificate request.
     */
    public function show(CertificateRequest $certificateRequest)
    {
        // Ensure user can only view their own requests
        if ($certificateRequest->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('certificates.show', compact('certificateRequest'));
    }
}
