<x-mail::message>
Kami dari tim Rekrutmen **Tumbas Coffee** ingin menginformasikan bahwa terdapat pembaruan pada status pendaftaran Anda sebagai Rider.

@if($riderProfile->application_status === 'verifikasi_berkas' && $riderProfile->employment_status === 'terima')
<x-mail::panel>
**Status Pendaftaran:** Berkas Diverifikasi (Lolos)
</x-mail::panel>

Selamat! Berkas pendaftaran yang Anda kirimkan telah berhasil kami verifikasi dan memenuhi kriteria awal kami. 

Silakan bersiap untuk tahapan selanjutnya, yaitu sesi wawancara. Tim kami akan segera menghubungi Anda atau mengirimkan pembaruan melalui sistem terkait jadwal wawancara Anda.

@elseif($riderProfile->application_status === 'verifikasi_berkas' && $riderProfile->employment_status === 'ditolak')
<x-mail::panel>
**Status Pendaftaran:** Berkas Diverifikasi (Belum Lolos)
</x-mail::panel>

Mohon maaf, setelah melakukan proses verifikasi dengan saksama, berkas pendaftaran Anda belum memenuhi kualifikasi yang kami butuhkan untuk posisi Rider saat ini.

Kami mengapresiasi waktu dan ketertarikan Anda untuk bergabung dengan Tumbas Coffee. Jangan patah semangat dan Anda dipersilakan untuk melamar kembali di kesempatan berikutnya.

@elseif($riderProfile->application_status === 'wawancara')
<x-mail::panel>
**Status Pendaftaran:** Tahap Wawancara
</x-mail::panel>

Anda telah terpilih untuk melanjutkan ke tahap wawancara! Berikut adalah detail atau instruksi wawancara dari tim rekrutmen kami:

<x-mail::panel>
{!! nl2br(e($riderProfile->interview_message)) !!}
</x-mail::panel>

Mohon persiapkan diri Anda dengan baik dan pastikan Anda hadir tepat waktu sesuai dengan instruksi di atas. Jika ada perubahan jadwal, tim kami akan menginformasikan kembali melalui email atau sistem.

@elseif($riderProfile->application_status === 'final_approval' && $riderProfile->employment_status === 'terima')
<x-mail::panel>
**Status Pendaftaran:** Persetujuan Akhir (Diterima)
</x-mail::panel>

**Selamat bergabung!** Anda telah melewati seluruh tahapan seleksi dengan sangat baik dan resmi diterima menjadi bagian dari keluarga besar **Tumbas Coffee**.

**Detail Kontrak Anda:**
- **Mulai:** {{ $riderProfile->contract_start_date ? \Carbon\Carbon::parse($riderProfile->contract_start_date)->translatedFormat('d F Y') : '-' }}
- **Selesai:** {{ $riderProfile->contract_end_date ? \Carbon\Carbon::parse($riderProfile->contract_end_date)->translatedFormat('d F Y') : 'Selesai' }}

Silakan login ke dashboard Anda untuk melihat panduan selanjutnya, atau Anda dapat segera menghubungi Supervisor Area penempatan Anda untuk proses onboarding.

@elseif($riderProfile->application_status === 'final_approval' && $riderProfile->employment_status === 'ditolak')
<x-mail::panel>
**Status Pendaftaran:** Persetujuan Akhir (Belum Lolos)
</x-mail::panel>

Mohon maaf, setelah melalui pertimbangan pada tahap persetujuan akhir, kami memutuskan untuk tidak melanjutkan proses pendaftaran Anda pada kesempatan ini.

Terima kasih atas antusiasme dan partisipasi Anda dalam seluruh rangkaian seleksi Rider Tumbas Coffee. Kami mendoakan kesuksesan untuk karir Anda ke depannya.

@elseif($riderProfile->employment_status === 'ditolak')
<x-mail::panel>
**Status Pendaftaran:** Belum Lolos Seleksi
</x-mail::panel>

Mohon maaf, berdasarkan evaluasi dari tim kami, Anda belum memenuhi kriteria untuk saat ini. Tetap semangat dan terima kasih atas ketertarikan Anda untuk bergabung dengan Tumbas Coffee.

@else
<x-mail::panel>
**Status Pendaftaran:** {{ $riderProfile->status_label }}
</x-mail::panel>

Tim kami sedang memproses aplikasi Anda ke tahap selanjutnya. Silakan periksa dashboard secara berkala.
@endif

Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim rekrutmen kami.
</x-mail::message>
