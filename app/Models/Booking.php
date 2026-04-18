<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusUpdated;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'flight_id',
        'pnr_code',
        'total_amount_usd',
        'status',
        'stripe_payment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected static function booted()
    {
        static::updated(function ($booking) {
            // Cek apakah kolom 'status' barusan diubah?
            if ($booking->wasChanged('status')) {
                // Jangan kirim email kalau statusnya pending (baru dibuat)
                if ($booking->status !== 'pending') {
                    // Ambil email user (pastikan relasi public function user() ada di model ini)
                    $email = $booking->user->email ?? 'naufal@test.com'; // Fallback

                    Mail::to($email)->send(new BookingStatusUpdated($booking));
                }
            }
        });
    }
}
