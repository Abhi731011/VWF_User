<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackagePurchase;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    private $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    }

    public function index()
    {
        $packages = Package::where('status', true)->get();

        return view('user.packages.index', compact('packages'));
    }

    public function initiatePayment(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'email' => 'required|email',
        ]);

        $package = Package::findOrFail($request->package_id);
        $user = Auth::user();

        // Create package purchase record
        $purchase = PackagePurchase::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'package_name' => $package->name,
            'email' => $request->email,
            'amount' => $package->price,
            'currency' => $package->currency ?? 'INR',
            'status' => 'pending',
        ]);

        try {
            // Create Razorpay order
            $orderData = [
                'receipt' => 'pkg_' . $purchase->id,
                'amount' => $package->price * 100, // Amount in paise
                'currency' => $package->currency ?? 'INR',
                'notes' => [
                    'package_id' => $package->id,
                    'package_name' => $package->name,
                    'user_id' => $user->id,
                    'purchase_id' => $purchase->id,
                ]
            ];

            $order = $this->razorpay->order->create($orderData);

            // Update purchase with order ID
            $purchase->update([
                'razorpay_order_id' => $order['id'],
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'key' => env('RAZORPAY_KEY_ID'),
                'purchase_id' => $purchase->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment initialization failed. Please try again.'
            ], 500);
        }
    }

    public function handlePaymentCallback(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature' => 'required',
            'purchase_id' => 'required|exists:package_purchases,id',
        ]);

        $purchase = PackagePurchase::findOrFail($request->purchase_id);

        try {
            // Verify payment signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            // Update purchase record
            $purchase->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'completed',
                'payment_details' => $attributes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful!',
                'purchase_id' => $purchase->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Payment verification failed: ' . $e->getMessage());
            
            $purchase->update(['status' => 'failed']);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed. Please contact support.'
            ], 400);
        }
    }

    public function paymentSuccess($purchaseId)
    {
        $purchase = PackagePurchase::with(['package', 'user'])->findOrFail($purchaseId);
        
        if ($purchase->status !== 'completed') {
            return redirect()->route('packages.index')->with('error', 'Invalid purchase.');
        }

        return view('user.packages.success', compact('purchase'));
    }

    public function myPurchases()
    {
        $purchases = PackagePurchase::with(['package'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.packages.my-purchases', compact('purchases'));
    }
}
