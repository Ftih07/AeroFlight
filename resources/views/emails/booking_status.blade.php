<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Update</title>
</head>

<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #334155; margin: 0; padding: 40px 20px;">

    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden;">
        <tr>
            <td style="background-color: #2563eb; padding: 20px 30px; text-align: center;">
                <span style="color: #ffffff; font-size: 20px; font-weight: bold; letter-spacing: 1px;">✈️ AeroFlight</span>
            </td>
        </tr>

        <tr>
            <td style="padding: 30px;">
                <h2 style="margin-top: 0; color: #0f172a; font-size: 20px;">Hello, {{ $booking->user->name ?? 'Passenger' }},</h2>
                <p style="line-height: 1.6; color: #475569;">We want to inform you about a recent update to your flight booking.</p>

                <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; border-radius: 6px; margin: 25px 0;">
                    <tr>
                        <td style="padding: 20px;">
                            <p style="margin: 0 0 10px 0; font-size: 14px;"><strong>PNR Code:</strong> <span style="color: #2563eb; font-weight: bold;">{{ $booking->pnr_code ?? 'N/A' }}</span></p>
                            <p style="margin: 0 0 15px 0; font-size: 14px;"><strong>Flight:</strong> {{ $booking->flight->flight_number }} ({{ $booking->flight->origin_airport }} &rarr; {{ $booking->flight->destination_airport }})</p>

                            <table width="100%">
                                <tr>
                                    <td style="background-color: #ffffff; border: 1px solid #cbd5e1; padding: 10px; text-align: center; border-radius: 4px;">
                                        <span style="font-size: 12px; color: #64748b; text-transform: uppercase;">New Status</span><br>
                                        <strong style="color: #2563eb; font-size: 18px; text-transform: uppercase;">{{ $booking->status }}</strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <p style="line-height: 1.6; color: #475569; margin-bottom: 0;">If you have any questions, feel free to contact our support team.<br><br>Thank you for choosing AeroFlight!</p>
            </td>
        </tr>

        <tr>
            <td style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;">
                <p style="margin: 0; font-size: 12px; color: #94a3b8;">&copy; {{ date('Y') }} AeroFlight. All rights reserved.</p>
            </td>
        </tr>
    </table>

</body>

</html>