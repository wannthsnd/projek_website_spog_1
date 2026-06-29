<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class PermitRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $permit;
    protected $rejectionNotes;

    public function __construct($permit, $rejectionNotes)
    {
        $this->permit = $permit;
        $this->rejectionNotes = $rejectionNotes;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Permohonan SPOG Ditolak - ' . $this->permit->ship_name)
            ->error()
            ->greeting('Permohonan Anda Ditolak')
            ->line('Permohonan SPOG untuk kapal <strong>' . $this->permit->ship_name . '</strong> telah ditolak.')
            ->line('Alasan penolakan:')
            ->line($this->rejectionNotes)
            ->action('Lihat Detail Permohonan', URL::to('/permohonan/' . $this->permit->id . '/detail'))
            ->line('Silakan perbaiki data/dokumen yang tidak sesuai dan ajukan kembali.');
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Permohonan Ditolak',
            'message' => 'Permohonan SPOG untuk kapal "' . $this->permit->ship_name . '" ditolak. Catatan: ' . $this->rejectionNotes,
            'icon' => 'x-circle',
            'color' => 'red',
            'action_url' => '/permohonan/' . $this->permit->id . '/detail',
            'permit_id' => $this->permit->id,
            'rejection_notes' => $this->rejectionNotes,
        ];
    }
}
