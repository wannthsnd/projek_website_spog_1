<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PermitApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $permit;

    public function __construct($permit)
    {
        $this->permit = $permit;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Permohonan Disetujui! 🎉',
            'message' => 'Permohonan SPOG untuk kapal "' . $this->permit->ship_name . '" telah disetujui. Silakan unduh surat SPOG resmi.',
            'permit_id' => $this->permit->id,
            'permit_name' => $this->permit->ship_name,
            'status' => 'approved',
            'icon' => 'check-circle',
            'color' => 'green',
            'action_url' => route('permohonan.detail', $this->permit->id),
            'action_text' => 'Lihat Detail',
        ];
    }
}
