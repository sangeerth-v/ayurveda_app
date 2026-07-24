<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Appointment Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
        <h2 style="color: #2d6a4f; border-bottom: 2px solid #2d6a4f; padding-bottom: 10px;">🌿 New Booking Request</h2>
        <p>Dear Dr. {{ $booking->doctor->name }},</p>
        <p>A patient has requested to book an appointment with you. Below are the details:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px;">
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #f0f0f0; width: 35%;">Patient Name:</td>
                <td style="padding: 8px; border-bottom: 1px solid #f0f0f0;">{{ $booking->user->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #f0f0f0;">Date:</td>
                <td style="padding: 8px; border-bottom: 1px solid #f0f0f0;">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #f0f0f0;">Time:</td>
                <td style="padding: 8px; border-bottom: 1px solid #f0f0f0;">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</td>
            </tr>
        </table>

        <p>Please log in to your dashboard to review and approve or reject this booking request.</p>
        
        <div style="margin-top: 25px; text-align: center;">
            <a href="{{ route('doctor.dashboard') }}" style="background-color: #2d6a4f; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Go to Doctor Dashboard</a>
        </div>
        
        <p style="margin-top: 30px; font-size: 0.9em; color: #777; border-top: 1px solid #e0e0e0; padding-top: 15px;">
            This is an automated notification from the Ayurveda Platform.
        </p>
    </div>
</body>
</html>
