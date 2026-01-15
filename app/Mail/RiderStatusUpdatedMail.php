<?php

namespace App\Mail;

use App\Models\RiderProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RiderStatusUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $riderProfile;

    public function __construct(RiderProfile $riderProfile)
    {
        $this->riderProfile = $riderProfile;
    }

    public function envelope(): Envelope
    {
        $statusContext = 'Proses Seleksi';
        
        if ($this->riderProfile->application_status === 'verifikasi_berkas' && $this->riderProfile->employment_status === 'terima') {
            $statusContext = 'Verifikasi Berkas Diterima';
        } elseif ($this->riderProfile->application_status === 'wawancara') {
            $statusContext = 'Jadwal Wawancara';
        } elseif ($this->riderProfile->application_status === 'final_approval' && $this->riderProfile->employment_status === 'terima') {
            $statusContext = 'Persetujuan Akhir Diterima';
        } elseif ($this->riderProfile->employment_status === 'ditolak') {
            if ($this->riderProfile->application_status === 'verifikasi_berkas') {
                $statusContext = 'Verifikasi Berkas Ditolak';
            } elseif ($this->riderProfile->application_status === 'final_approval') {
                $statusContext = 'Persetujuan Akhir Ditolak';
            } else {
                $statusContext = 'Belum Lolos Seleksi';
            }
        }

        return new Envelope(
            subject: "Update Status [$statusContext] - Pendaftaran Rider Tumbas Coffee",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rider_status_updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
