<div style="font-family: sans-serif; padding: 20px;">
    <h2>Hello, {{ $booking->user->name ?? 'Passenger' }}</h2>
    <p>We want to inform you about a recent update to your flight booking.</p>

    <div style="background: #f4f4f5; padding: 15px; border-radius: 8px;">
        <p><strong>PNR Code:</strong> {{ $booking->pnr_code ?? 'N/A' }}</p>
        <p><strong>Flight:</strong> {{ $booking->flight->flight_number }} ({{ $booking->flight->origin_airport }} to {{ $booking->flight->destination_airport }})</p>
        <h3 style="color: #2563eb;">New Status: {{ strtoupper($booking->status) }}</h3>
    </div>

    <p>Thank you for choosing AeroFlight!</p>
</div>