<?php

namespace App\Mail;

use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttendanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Siswa $siswa;
    public Presensi $presensi;

    /**
     * Create a new message instance.
     */
    public function __construct(Siswa $siswa, Presensi $presensi)
    {
        $this->siswa = $siswa;
        $this->presensi = $presensi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Presensi - ' . $this->siswa->nama,
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
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
