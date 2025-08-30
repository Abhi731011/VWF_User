<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\UserRegistrationNotification;
use App\Notifications\AdminRegistrationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send registration notifications to user and admin
     *
     * @param User $user
     * @return void
     */
    public static function sendRegistrationNotifications(User $user): array
    {
        $results = [
            'user_email_sent' => false,
            'admin_email_sent' => false,
            'user_email_error' => null,
            'admin_email_error' => null
        ];

        try {
            // Send welcome email to the new user
            $user->notify(new UserRegistrationNotification($user));
            $results['user_email_sent'] = true;
        } catch (\Exception $e) {
            $results['user_email_error'] = $e->getMessage();
            
            // Try alternative method for user email
            try {
                Mail::send('emails.welcome', ['user' => $user], function($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Welcome to Vaishvik Welfare Foundation!');
                });
                $results['user_email_sent'] = true;
            } catch (\Exception $altException) {
                $results['user_email_error'] = $altException->getMessage();
            }
        }

        try {
            // Send notification to admin
            $adminEmail = 'info.vaishvikwelfare@gmail.com';
            
            // Create a notification instance for admin
            $adminNotification = new AdminRegistrationNotification($user);
            
            // Send to admin using Notification facade
            Notification::route('mail', $adminEmail)
                ->notify($adminNotification);
            $results['admin_email_sent'] = true;

        } catch (\Exception $e) {
            $results['admin_email_error'] = $e->getMessage();
            
            // Try alternative method for admin email
            try {
                Mail::send('emails.admin-notification', ['user' => $user], function($message) {
                    $message->to('info.vaishvikwelfare@gmail.com')
                            ->subject('New User Registration - Vaishvik Welfare Foundation');
                });
                $results['admin_email_sent'] = true;
            } catch (\Exception $altException) {
                $results['admin_email_error'] = $altException->getMessage();
            }
        }

        return $results;
    }


}
