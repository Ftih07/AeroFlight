<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Seat;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function passengerForm(Request $request, Flight $flight)
    {
        $request->validate(['seat_ids' => 'required|array|min:1']);
        $seats = $flight->seats()->whereIn('id', $request->seat_ids)->get();

        return Inertia::render('Flights/PassengerForm', [
            'flight' => $flight,
            'selectedSeats' => $seats
        ]);
    }

    public function checkout(Request $request, Flight $flight)
    {
        $request->validate([
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.last_name' => 'required|string',
            'passengers.*.seat_id' => 'required|exists:seats,id',
        ]);

        return DB::transaction(function () use ($request, $flight) {
            $totalPrice = 0;
            foreach ($request->passengers as $p) {
                $seat = Seat::find($p['seat_id']);
                $totalPrice += $flight->base_price_usd + $seat->additional_price_usd;
            }

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'flight_id' => $flight->id,
                'total_amount_usd' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($request->passengers as $p) {
                Passenger::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $p['seat_id'],
                    'first_name' => $p['first_name'],
                    'last_name' => $p['last_name'],
                    'passport_number' => $p['passport_number'] ?? null,
                ]);
                Seat::where('id', $p['seat_id'])->update(['is_available' => false]);
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'Flight ' . $flight->flight_number . ' to ' . $flight->destination_airport],
                        'unit_amount' => $totalPrice * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('flights.seats', $flight->id),
                'metadata' => ['booking_id' => $booking->id]
            ]);

            $booking->update(['stripe_payment_id' => $checkoutSession->id]);

            return Inertia::location($checkoutSession->url);
        });
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($request->session_id);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('home')->with('error', 'Pembayaran belum diselesaikan.');
        }

        $booking = Booking::with(['flight', 'passengers'])->find($session->metadata->booking_id);

        if ($booking && $booking->status === 'pending') {
            $booking->update([
                'status' => 'paid',
                'pnr_code' => strtoupper(Str::random(6)),
            ]);

            $booking->transactions()->create([
                'type' => 'payment',
                'amount' => $booking->total_amount_usd,
                'description' => 'Initial payment received via Stripe'
            ]);

            $pdf = Pdf::loadView('emails.ticket', ['booking' => $booking]);
            Mail::to($request->user()->email)->send(new BookingConfirmed($booking, $pdf->output()));
        }

        return Inertia::render('Checkout/Success', ['booking' => $booking]);
    }
}
