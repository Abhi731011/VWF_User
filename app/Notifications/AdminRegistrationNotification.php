<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class AdminRegistrationNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from('info.vaishvikwelfare@gmail.com', 'Vaishvik Welfare Foundation')
            ->subject('New User Registration - Vaishvik Welfare Foundation')
            ->greeting('Hello Admin!')
            ->line('A new user has successfully registered on the Vaishvik Welfare Foundation website.')
            ->line('User Details:')
            ->line('Name: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->line('Registration Date: ' . $this->user->created_at->format('F j, Y \a\t g:i A'))
            ->line('User ID: ' . $this->user->id)
            ->action('View User Dashboard', route('dashboard'))
            ->line('Please review the new registration and take any necessary actions.')
            ->salutation('Best regards, Vaishvik Welfare Foundation System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'registration_date' => $this->user->created_at,
        ];
    }
}
