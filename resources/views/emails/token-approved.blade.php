<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmed</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
        <h2 style="color: #40916c; border-bottom: 2px solid #40916c; padding-bottom: 10px;">🌿 Appointment Confirmed</h2>
        <p>Dear {{ $booking->user->name }},</p>
        <p>Great news! Your booking request has been approved by the doctor. Here are the confirmed details:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px;">
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #f0f0f0; width: 35%;">Doctor:</td>
                <td style="padding: 8px; border-bottom: 1px solid #f0f0f0;">Dr. {{ $booking->doctor->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #f0f0f0;">Date:</td>
                <td style="padding: 8px; border-bottom: 1px solid #f0f0f0;">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #f0f0f0;">Time:</td>
                <td style="padding: 8px; border-bottom: 1px solid #f0f0f0;">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #f0f0f0;">Status:</td>
                <td style="padding: 8px; border-bottom: 1px solid #f0f0f0; color: #40916c; font-weight: bold;">Confirmed (Booked)</td>
            </tr>
        </table>

        <p>You can view all your appointments under the "My Appointments" section of your profile.</p>
        
        <div style="margin-top: 25px; text-align: center;">
            <a href="{{ route('bookings.my') }}" style="background-color: #40916c; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">View My Appointments</a>
        </div>
        
        <p style="margin-top: 30px; font-size: 0.9em; color: #777; border-top: 1px solid #e0e0e0; padding-top: 15px;">
            Thank you for choosing our Ayurveda Platform.
        </p>
    </div>
</body>
</html>
