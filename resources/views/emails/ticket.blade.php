<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>E-Ticket AeroFlight - {{ $booking->pnr_code }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #374151;
            margin: 0;
            padding: 0;
        }

        .ticket-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .header {
            background-color: #2563eb;
            color: #ffffff;
            padding: 25px 30px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .header table {
            width: 100%;
            border: none;
        }

        .header td {
            border: none;
            padding: 0;
            color: #ffffff;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .pnr-box {
            text-align: right;
        }

        .pnr-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #bfdbfe;
        }

        .pnr-code {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        .content {
            padding: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .info-table th {
            background-color: #f3f4f6;
            color: #4b5563;
            font-size: 12px;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }

        .info-table td {
            padding: 12px 10px;
            font-size: 14px;
            border: 1px solid #e5e7eb;
        }

        .total-row td {
            font-weight: bold;
            font-size: 16px;
            background-color: #eff6ff;
            color: #1d4ed8;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            border-top: 1px dashed #d1d5db;
        }
    </style>
</head>

<body>

    <div class="ticket-container">
        <div class="header">
            <table>
                <tr>
                    <td class="logo">
                        AeroFlight
                    </td>
                    <td class="pnr-box">
                        <div class="pnr-title">Booking Reference (PNR)</div>
                        <div class="pnr-code">{{ $booking->pnr_code }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="content">

            <div class="section-title">Flight Details</div>
            <table class="info-table">
                <tr>
                    <th>Flight No.</th>
                    <th>Route</th>
                    <th>Status</th>
                    <th>Date Issued</th>
                </tr>
                <tr>
                    <td><strong>{{ $booking->flight->flight_number }}</strong></td>
                    <td>{{ $booking->flight->origin_airport }} - {{ $booking->flight->destination_airport }}</td>
                    <td><strong style="color: #059669; text-transform: uppercase;">{{ $booking->status }}</strong></td>
                    <td>{{ $booking->created_at->format('d M Y, H:i') }}</td>
                </tr>
            </table>

            <div class="section-title">Passenger Details</div>
            <table class="info-table">
                <tr>
                    <th>No.</th>
                    <th>Passenger Name</th>
                    <th>Passport / ID</th>
                    <th>Seat Code</th>
                </tr>
                @foreach($booking->passengers as $index => $passenger)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td><strong>{{ strtoupper($passenger->first_name . ' ' . $passenger->last_name) }}</strong></td>
                    <td>{{ $passenger->passport_number ?? '-' }}</td>
                    <td><strong>{{ $passenger->seat->seat_code ?? '-' }}</strong></td>
                </tr>
                @endforeach
            </table>

            <div class="section-title">Payment Summary</div>
            <table class="info-table">
                <tr>
                    <th colspan="3" style="text-align: right;">Base Ticket Price (x{{ $booking->passengers->count() }})</th>
                    <td style="text-align: right;">${{ number_format($booking->flight->base_price_usd * $booking->passengers->count(), 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">TOTAL PAID</td>
                    <td style="text-align: right;">${{ number_format($booking->total_amount_usd, 2) }}</td>
                </tr>
            </table>

        </div>

        <div class="footer">
            <p>Thank you for choosing AeroFlight. Please arrive at the airport at least 2 hours before departure.</p>
            <p>&copy; {{ date('Y') }} AeroFlight by Naufal Fathi. Part of Portfolio Project.</p>
        </div>
    </div>

</body>

</html>