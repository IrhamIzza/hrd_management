<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pengumuman;
use Illuminate\Support\Str;

class PengumumanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pengumuman;

    public function __construct(Pengumuman $pengumuman)
    {
        $this->pengumuman = $pengumuman;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pengumuman Baru: ' . $this->pengumuman->judul)
            ->greeting('Halo ' . $notifiable->name)
            ->line('Ada pengumuman baru yang perlu Anda ketahui:')
            ->line($this->pengumuman->judul)
            ->line(Str::limit(strip_tags($this->pengumuman->isi), 200))
            ->action('Lihat Pengumuman', route('karyawan.pengumuman.show', $this->pengumuman))
            ->line('Terima kasih telah memperhatikan pengumuman ini.');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Pengumuman Baru',
            'message' => $this->pengumuman->judul,
            'type' => 'info',
            'link' => route('karyawan.pengumuman.show', $this->pengumuman)
        ];
    }
} 