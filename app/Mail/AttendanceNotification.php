<?php

namespace App\Mail;

use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttendanceNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Siswa $siswa;

    public Presensi $presensi;

    public string $type;

    /**
     * Create a new message instance.
     */
    public function __construct(Siswa $siswa, Presensi $presensi, string $type = 'masuk')
    {
        $this->siswa = $siswa;
        $this->presensi = $presensi;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->type === 'pulang'
            ? 'Notifikasi Presensi Pulang - '.$this->siswa->nama
            : 'Notifikasi Presensi - '.$this->siswa->nama;

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.attendance',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
