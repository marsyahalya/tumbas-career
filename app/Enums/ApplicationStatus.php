<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case SUBMITTED = 'submitted';
    case DOCUMENT_VERIFICATION = 'document_verification';
    case INTERVIEW = 'interview';
    case FINAL_APPROVAL = 'final_approval';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::SUBMITTED => 'Submit',
            self::DOCUMENT_VERIFICATION => 'Verifikasi',
            self::INTERVIEW => 'Wawancara',
            self::FINAL_APPROVAL => 'Final Approval',
            self::ACCEPTED => 'Diterima',
            self::REJECTED => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::SUBMITTED => 'blue',
            self::DOCUMENT_VERIFICATION => 'yellow',
            self::INTERVIEW => 'purple',
            self::FINAL_APPROVAL => 'indigo',
            self::ACCEPTED => 'green',
            self::REJECTED => 'red',
        };
    }
}
