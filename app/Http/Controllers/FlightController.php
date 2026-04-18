<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FlightController extends Controller
{
    public function search(Request $request)
    {
        $query = Flight::query();

        if ($request->filled('origin') && $request->filled('destination')) {
            $query->where('origin_airport', strtoupper($request->origin))
                ->where('destination_airport', strtoupper($request->destination));
        }

        if ($request->filled('date')) {
            $query->whereDate('departure_at', $request->date);
        }

        return Inertia::render('Flights/Search', [
            'flights' => $query->orderBy('departure_at')->get(),
            'filters' => $request->only(['origin', 'destination', 'date'])
        ]);
    }

    public function selectSeat(Flight $flight)
    {
        $flight->load('seats');

        return Inertia::render('Flights/SelectSeat', [
            'flight' => $flight,
            'groupedSeats' => $flight->seats->groupBy(function ($seat) {
                return preg_replace('/[^0-9]/', '', $seat->seat_code);
            })
        ]);
    }
}
