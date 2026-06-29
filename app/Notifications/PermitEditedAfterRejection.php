<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class PermitEditedAfterRejection extends Notification implements ShouldQueue
{
    use Queueable;

    protected $permit;
    protected $user;

    public function __construct($permit, $user)
    {
        $this->permit = $permit;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Permohonan Diedit Ulang 🔁',
            'message' => 'Pengguna "' . $this->user->name . '" telah mengedit permohonan SPOG untuk kapal "' . $this->permit->ship_name . '" yang sebelumnya ditolak. Silakan tinjau ulang.',
            'permit_id' => $this->permit->id,
            'permit_name' => $this->permit->ship_name,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'status' => 'pending',
            'icon' => 'pencil',
            'color' => 'yellow',
            'action_url' => route('admin.permits.show', $this->permit->id),
            'action_text' => 'Tinjau Ulang',
        ];
    }
}
