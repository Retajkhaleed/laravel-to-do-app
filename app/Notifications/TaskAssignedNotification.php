<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskAssignedNotification extends Notification
{
    public function __construct(public Task $task) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Task Assigned to You')
            ->line("Task: {$this->task->title}")
            ->action('View Dashboard', url('/dashboard'))
            ->line('Login to see your tasks.');
    }
}