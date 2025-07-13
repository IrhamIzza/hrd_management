<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CutiRequest;

class CutiRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $cutiRequest;
    protected $type;

    public function __construct(CutiRequest $cutiRequest, string $type)
    {
        $this->cutiRequest = $cutiRequest;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        $user = $this->cutiRequest->user;
        $startDate = $this->cutiRequest->start_date->format('d/m/Y');
        $endDate = $this->cutiRequest->end_date->format('d/m/Y');

        switch ($this->type) {
            case 'new_request':
                return (new MailMessage)
                    ->subject('Pengajuan Cuti Baru')
                    ->greeting('Halo HRD')
                    ->line("{$user->name} telah mengajukan cuti:")
                    ->line("Tanggal: {$startDate} - {$endDate}")
                    ->line("Alasan: {$this->cutiRequest->reason}")
                    ->action('Lihat Detail', url('/cuti-requests/' . $this->cutiRequest->id))
                    ->line('Silakan tinjau pengajuan cuti ini.');

            case 'approved':
                return (new MailMessage)
                    ->subject('Pengajuan Cuti Disetujui')
                    ->greeting("Halo {$user->name}")
                    ->line('Pengajuan cuti Anda telah disetujui:')
                    ->line("Tanggal: {$startDate} - {$endDate}")
                    ->line("Alasan: {$this->cutiRequest->reason}")
                    ->action('Lihat Detail', url('/cuti-requests/' . $this->cutiRequest->id))
                    ->line('Terima kasih telah menggunakan sistem HRD.');

            case 'rejected':
                return (new MailMessage)
                    ->subject('Pengajuan Cuti Ditolak')
                    ->greeting("Halo {$user->name}")
                    ->line('Pengajuan cuti Anda telah ditolak:')
                    ->line("Tanggal: {$startDate} - {$endDate}")
                    ->line("Alasan: {$this->cutiRequest->reason}")
                    ->line("Alasan Penolakan: {$this->cutiRequest->rejection_reason}")
                    ->action('Lihat Detail', url('/cuti-requests/' . $this->cutiRequest->id))
                    ->line('Silakan hubungi HRD untuk informasi lebih lanjut.');

            default:
                return null;
        }
    }

    public function toArray($notifiable)
    {
        $user = $this->cutiRequest->user;
        $startDate = $this->cutiRequest->start_date->format('d/m/Y');
        $endDate = $this->cutiRequest->end_date->format('d/m/Y');

        switch ($this->type) {
            case 'new_request':
                return [
                    'title' => 'Pengajuan Cuti Baru',
                    'message' => "{$user->name} telah mengajukan cuti pada {$startDate} - {$endDate}",
                    'type' => 'info',
                    'link' => '/cuti-requests/' . $this->cutiRequest->id
                ];

            case 'approved':
                return [
                    'title' => 'Pengajuan Cuti Disetujui',
                    'message' => "Pengajuan cuti Anda pada {$startDate} - {$endDate} telah disetujui",
                    'type' => 'success',
                    'link' => '/cuti-requests/' . $this->cutiRequest->id
                ];

            case 'rejected':
                return [
                    'title' => 'Pengajuan Cuti Ditolak',
                    'message' => "Pengajuan cuti Anda pada {$startDate} - {$endDate} telah ditolak",
                    'type' => 'danger',
                    'link' => '/cuti-requests/' . $this->cutiRequest->id
                ];

            default:
                return null;
        }
    }
} 