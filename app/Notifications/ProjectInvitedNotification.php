<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectInvitedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Project $project,
        public User $invitedBy
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You have been added to a project')
            ->line("You were added to project: {$this->project->name}")
            ->line("Invited by: {$this->invitedBy->username}")
            ->action('View Project', url('/projects/' . $this->project->id))
            ->line('Login to see your project.');
    }
}