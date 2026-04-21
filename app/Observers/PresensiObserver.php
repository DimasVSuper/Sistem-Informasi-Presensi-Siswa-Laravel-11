<?php

namespace App\Observers;

use App\Mail\AttendanceNotification;
use App\Models\Presensi;
use Illuminate\Support\Facades\Mail;

class PresensiObserver
{
    public function created(Presensi $presensi): void
    {
        $siswa = $presensi->siswa()->with('orangTua')->first();

        if (! $siswa || ! $siswa->orangTua || ! $siswa->orangTua->email) {
            return;
        }

        Mail::to($siswa->orangTua->email)->send(new AttendanceNotification($siswa, $presensi));
    }
}
