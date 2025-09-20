<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EventRegistration;
use App\Models\Event;
use App\Models\CertificateRequest;
use App\Models\SupportFeedback;
use App\Models\PackagePurchase;
use App\Models\Donation;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // User's event registrations
        $userEventRegistrations = EventRegistration::where('user_id', $user->id)->get();
        $approvedRegistrations = $userEventRegistrations->where('status', 'approved')->count();
        $pendingRegistrations = $userEventRegistrations->where('status', 'pending')->count();
        
        // User's certificate requests
        $userCertificateRequests = CertificateRequest::where('user_id', $user->id)->get();
        $pendingCertificates = $userCertificateRequests->where('status', 'pending')->count();
        $approvedCertificates = $userCertificateRequests->where('status', 'approved')->count();
        
        // User's support feedback
        $userSupportFeedback = SupportFeedback::where('user_id', $user->id)->get();
        $openSupportTickets = $userSupportFeedback->where('status', 'open')->count();
        $resolvedSupportTickets = $userSupportFeedback->where('status', 'resolved')->count();
        
        // User's package purchases
        $userPackagePurchases = PackagePurchase::where('user_id', $user->id)->get();
        $completedPurchases = $userPackagePurchases->where('status', 'completed')->count();
        $totalPackageSpent = $userPackagePurchases->where('status', 'completed')->sum('amount');
        
        // User's donations
        $userDonations = Donation::where('user_id', $user->id)->get();
        $completedDonations = $userDonations->where('status', 'completed')->count();
        $totalDonated = $userDonations->where('status', 'completed')->sum('amount');
        
        // Upcoming events (next 30 days)
        $upcomingEvents = Event::where('status', 'published')
            ->where('visibility', true)
            ->where('event_date', '>=', Carbon::now())
            ->where('event_date', '<=', Carbon::now()->addDays(30))
            ->orderBy('event_date', 'asc')
            ->limit(4)
            ->get();
        
        // Recent user registrations
        $recentUserRegistrations = EventRegistration::where('user_id', $user->id)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Recent user donations
        $recentUserDonations = Donation::where('user_id', $user->id)
            ->with('project')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Recent user package purchases
        $recentUserPurchases = PackagePurchase::where('user_id', $user->id)
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Recent user certificate requests
        $recentUserCertificates = CertificateRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Recent user support feedback
        $recentUserSupport = SupportFeedback::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Available events count
        $availableEventsCount = Event::where('status', 'published')
            ->where('visibility', true)
            ->where('event_date', '>=', Carbon::now())
            ->count();
        
        // Available projects count
        $availableProjectsCount = Project::where('status', 'published')
            ->where('visibility', true)
            ->count();
        
        // Available packages count
        $availablePackagesCount = \App\Models\Package::where('status', true)->count();
        
        return view('master.dashboard', compact(
            'user',
            'approvedRegistrations',
            'pendingRegistrations',
            'pendingCertificates',
            'approvedCertificates',
            'openSupportTickets',
            'resolvedSupportTickets',
            'completedPurchases',
            'totalPackageSpent',
            'completedDonations',
            'totalDonated',
            'upcomingEvents',
            'recentUserRegistrations',
            'recentUserDonations',
            'recentUserPurchases',
            'recentUserCertificates',
            'recentUserSupport',
            'availableEventsCount',
            'availableProjectsCount',
            'availablePackagesCount'
        ));
    }

    public function profile()
    {
        return view('master.profile');
    }
}
