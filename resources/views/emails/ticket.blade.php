<div style="font-family: sans-serif; border: 2px solid #3b82f6; border-radius: 10px; padding: 20px; max-width: 600px;">
    <h1 style="color: #3b82f6;">AeroFlight E-Ticket</h1>
    <hr>
    <div style="margin-bottom: 20px;">
        <p><strong>PNR CODE:</strong> <span style="font-size: 24px; color: #1e40af;">{{ $booking->pnr_code }}</span></p>
        <p><strong>Passenger(s):</strong></p>
        <ul>
            @foreach($booking->passengers as $p)
            <li>{{ $p->first_name }} {{ $p->last_name }}</li>
            @endforeach
        </ul>
    </div>
    <div style="background: #f3f4f6; padding: 15px;">
        <p><strong>Flight:</strong> {{ $booking->flight->flight_number }}</p>
        <p><strong>Route:</strong> {{ $booking->flight->origin_airport }} to {{ $booking->flight->destination_airport }}</p>
        <p><strong>Departure:</strong> {{ \Carbon\Carbon::parse($booking->flight->departure_at)->format('d M Y, H:i') }}</p>
    </div>
</div>