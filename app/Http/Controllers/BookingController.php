<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function history(Request $request)
    {
        $userId = auth()->id();
        $bookings = Booking::with(['flight', 'transactions'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Bookings/History', ['bookings' => $bookings]);
    }

    public function downloadTicket(Booking $booking)
    {
        $pdf = Pdf::loadView('emails.ticket', ['booking' => $booking]);
        return $pdf->download('Ticket-' . $booking->pnr_code . '.pdf');
    }

    public function requestRefund(Booking $booking)
    {
        if ($booking->status === 'paid') {
            $booking->update(['status' => 'refund_requested']);
        }
        return back()->with('message', 'Refund request submitted successfully.');
    }
}
